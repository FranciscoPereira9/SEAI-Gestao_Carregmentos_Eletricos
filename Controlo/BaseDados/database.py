import psycopg2
from datetime import datetime


class database:
    user = "up201504961"
    database = "up201504961"
    password = "32FiuJr2X"
    port = "5432"
    host = "db.fe.up.pt"

    def start_charging(self, charger_id, max_curr, charge_type):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            # INSERE EM CHARGING
            now = datetime.now()
            query = 'insert into "seai".charging (charger_id, starting_time, charge_type, starting_date, avg_power) ' \
                    'values (%s, %s, %s, %s, 0)'
            cursor.execute(cursor.mogrify(query, (charger_id, now.time(), charge_type, now.date())))

            conn.commit()

            # VAI BUSCAR ID DO CARREGAMENTO
            query = 'select id from "seai".charging where starting_date=%s and starting_time=%s'
            cursor.execute(cursor.mogrify(query, (now.date(), now.time())))
            charging_id = cursor.fetchone()[0]

            # INSERE EM HISTORICO
            query = 'insert into "seai".historic (charger_id, charging_id, current, voltage, time, date) values (%s, ' \
                    '%s, 0, 0, %s, %s)'
            cursor.execute(cursor.mogrify(query, (charger_id, charging_id, now.time(), now.date())))
            conn.commit()

            # ATUALIZA CARREGADOR
            query = 'update "seai".charger set max_curr=%s, charging_id=%s, charging_mode=%s where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (max_curr, charging_id, charge_type, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating info on start charging", error)
        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def stop_charging(self, charger_id, fori):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            self.new_measure(charger_id, 0, 0)

            now = datetime.now()

            # BUSCA ID CARREGAMENTO
            charging_id = self.get_charging_id(charger_id)

            # FAZ UPDATE EM CHARGING
            query = 'update "seai".charging set stoping_time=%s, fori=%s, ending_date=%s where id=%s'
            cursor.execute(cursor.mogrify(query, (now.time(), fori, now.date(), charging_id)))
            conn.commit()

            # FAZ UPDATE NO CARREGADOR
            query = 'update "seai".charger set voltage_inst=0, current_inst=0, charging_id=0, max_curr=0 where ' \
                    'charger_id=%s'
            cursor.execute(cursor.mogrify(query, (charger_id,)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating info on start charging", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def new_measure(self, charger_id, current, voltage):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            charging_id = self.get_charging_id(charger_id)

            now = datetime.now()

            intervalo_atual_s = self.get_actual_interval(charging_id, now)
            intervalo_total_s = self.get_total_interval(charging_id, now)

            # INSERE NO HISTÓRICO
            # now = datetime.now()
            query = 'insert into "seai".historic (charger_id, charging_id, current, voltage, time, date) values' \
                    '(%s, %s, %s, %s, %s, %s);'
            cursor.execute(cursor.mogrify(query, (charger_id, charging_id, current, voltage, now.time(), now.date())))
            conn.commit()



            # CÁLCULO POTÊNCIA MÉDIA
            avg_power = self.get_avg_power(charging_id, intervalo_total_s, intervalo_atual_s)
            # print(avg_power)

            # FAZ UPDATE CARREGADOR
            self.update_charger_measures(voltage, current, charger_id)

            # FAZ UPDATE CARREGAMENTO
            query = 'update "seai".charging set avg_power=%s where id=%s'
            cursor.execute(cursor.mogrify(query, (avg_power, charging_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while new_measure", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def charger_interr(self, charger_id):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            # INSERE HISTÓRICO
            self.new_measure(charger_id, 0, 0)

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while new_measure", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def charger_emer(self):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            charger_id = self.get_active_chargers_id()
            # print(charger_id)
            for i in charger_id:
                # print(i)
                self.charger_interr(charger_id[i-1])

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while charger_emer", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return


    ##########################################################################################
    #######################                                             ######################
    #######################          FUNÇÕES AUXILIARES                 ######################
    #######################                                             ######################
    ##########################################################################################

    def connect(self):

        try:
            conn = psycopg2.connect(user=self.user,
                                    password=self.password,
                                    host=self.host,
                                    port=self.port,
                                    database=self.database)

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while connecting", error)
        finally:
            return conn

    def update_charger_measures(self, voltage, current, charger_id):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'update "seai".charger set voltage_inst=%s, current_inst=%s where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (voltage, current, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating charger table", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def get_charging_id(self, charger_id):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'select charging_id from "seai".charger where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (charger_id,)))
            charging_id = cursor.fetchone()[0]

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating charger table", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return charging_id

    def get_total_interval(self, charging_id, timestamp_now):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'select starting_time, starting_date from "seai".charging where id=%s'
            cursor.execute(cursor.mogrify(query, (charging_id,)))
            row = cursor.fetchall()[0]
            intervalo_total = timestamp_now - datetime.combine(row[1], row[0])
            intervalo_total_s = float(intervalo_total.total_seconds())

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating charger table", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return intervalo_total_s

    def get_actual_interval(self, charging_id, timestamp_now):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'select time, date from "seai".historic where charging_id=%s order by date desc, time desc'
            cursor.execute(cursor.mogrify(query, (charging_id,)))
            row = cursor.fetchall()
            # row[1] porque row[0] é medição inserida nesta função
            intervalo_atual = timestamp_now - datetime.combine(row[0][1], row[0][0])
            intervalo_atual_s = float(intervalo_atual.total_seconds())

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating charger table", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return intervalo_atual_s

    def get_avg_power(self, charging_id, total_time, actual_time):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            # CÁLCULO POTÊNCIA MÉDIA
            query = 'select avg_power from "seai".charging where id=%s'
            cursor.execute(cursor.mogrify(query, (charging_id,)))
            power_avg = float(cursor.fetchone()[0])
            query = 'select voltage_inst, current_inst from "seai".charger where charging_id=%s'
            cursor.execute(cursor.mogrify(query, (charging_id,)))
            row = cursor.fetchall()[0]
            power_atual = float(row[0] * row[1])

            new_power = power_atual * actual_time / total_time + \
                        power_avg * (1 - actual_time / total_time)


        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating charger table", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return new_power

    def get_active_chargers_id(self):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'select charger_id from "seai".charger where max_curr>0'
            cursor.execute(query)
            # print(cursor.fetchall())
            charger_id = []
            for row in cursor.fetchall():
                charger_id.append(row[0])



        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while new_measure", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return charger_id
