import psycopg2
from datetime import datetime


class database:
    user = "up201504961"
    database = "up201504961"
    password = "32FiuJr2X"
    port = "5432"
    host = "db.fe.up.pt"

    def start_charging(self, charger_id, max_curr, charge_type_int, voltage_mode, new_connection, state_occupation_int, charge_type_green):
        state_occupation = True if state_occupation_int == 1 else False
        # print(state_occupation)
        # print(state_occupation_int)
        charge_type = True if charge_type_int == 1 else False
        try:
            conn = self.connect()
            cursor = conn.cursor()

            # ALTERAR QUANDO FOR POSSÍVEL POR CARREGAMENTO VERDE
            price = self.get_price_pkwh(charger_id, charge_type, charge_type_green)

            # INSERE EM CHARGING
            now = datetime.now()
            query = 'insert into "seai".charging (charger_id, starting_time, charge_type, starting_date, avg_power, ' \
                    'voltage_mode, priceper_kwh) values (%s, %s, %s, %s, 0, %s, %s) '
            cursor.execute(cursor.mogrify(query, (charger_id, now.time(), charge_type, now.date(), voltage_mode, price)))

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
            # print(state_occupation)
            query = 'update "seai".charger set max_curr=%s, charging_id=%s, charging_mode=%s, state_occupation=%s, ' \
                    'new_connection=%s where charger_id=%s '

            # print(cursor.mogrify(query, (max_curr, charging_id, charge_type, state_occupation,
            #                                       new_connection, charger_id)))
            cursor.execute(cursor.mogrify(query, (max_curr, charging_id, charge_type, state_occupation,
                                                  new_connection, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while start_charging()", error)
        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def stop_charging(self, charger_id, fori, state_occupation_int):
        state_occupation = True if state_occupation_int == 1 else False
        fori = True if fori == 1 else False

        try:
            conn = self.connect()
            cursor = conn.cursor()
            # print(1)
            self.new_measure(charger_id, 400, 0, 0)

            now = datetime.now()

            # BUSCA ID CARREGAMENTO
            charging_id = self.get_charging_id(charger_id)

            total_cost = 0
            if not fori:
                total_cost = self.get_total_cost(charging_id)

            # FAZ UPDATE EM CHARGING
            query = 'update "seai".charging set stoping_time=%s, fori=%s, ending_date=%s, total_cost=%s where id=%s'
            cursor.execute(cursor.mogrify(query, (now.time(), fori, now.date(), total_cost, charging_id)))
            conn.commit()

            # FAZ UPDATE NO CARREGADOR
            # query = 'update "seai".charger set voltage_inst=0, current_inst=0, charging_id=0, max_curr=0 where ' \
            #         'charger_id=%s'
            # cursor.execute(cursor.mogrify(query, (charger_id,)))
            # conn.commit()
            self.update_charger_measures(0, 0, charger_id, 0)
            query = 'update "seai".charger set charging_id=0, state_occupation=%s where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (state_occupation, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while stop_charging()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def new_measure(self, charger_id, current, voltage, max_curr):

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
            avg_power = self.get_avg_power2(charging_id, intervalo_total_s, intervalo_atual_s)
            # print(avg_power)

            # FAZ UPDATE CARREGADOR
            # print(voltage, current, max_curr, charger_id)
            self.update_charger_measures(voltage, current, charger_id, max_curr)

            # FAZ UPDATE CARREGAMENTO
            query = 'update "seai".charging set avg_power=%s where id=%s'
            cursor.execute(cursor.mogrify(query, (avg_power, charging_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while new_measure()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def charger_interr(self, charger_id, state_occupation_int):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            # PARA CARREGAMENTO
            self.stop_charging(charger_id, 1, state_occupation_int)
        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while charger_interr()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def charger_emer(self, state_occupation_int):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            charger_id = self.get_active_chargers_id()
            # print(charger_id)
            for i in charger_id:
                # print(i)
                self.charger_interr(i, state_occupation_int)

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while charger_emer()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def new_connection(self, charger_id, connection):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'update "seai".charger set new_connection=%s where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (connection, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while inserting new_connection()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def update_green_power(self, charger_id, green_power_state):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'update "seai".charger set green_power=%s where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (green_power_state, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while update_green_power()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def update_all_green_power(self, green_power_state):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            charger_id = self.get_all_chargers_id()
            for i in charger_id:
                self.update_green_power(i, green_power_state)

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while update_all_green_power", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def update_fc_availability(self, charger_id, fc_state_int):
        fc_state = True if fc_state_int == 1 else False
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'update "seai".charger set fc_availability=%s where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (fc_state, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while update_fc_availability", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def update_all_fc_availability(self, fc_state_int):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            charger_id = self.get_all_chargers_id()
            for i in charger_id:
                self.update_fc_availability(i, fc_state_int)

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while update_all_fc_availability", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def update_charge_state(self, charger_id, charge_state):

        try:
            conn = self.connect()
            cursor = conn.cursor()

            charging_id = self.get_charging_id(charger_id)

            query = 'update "seai".charging set charge_state=%s where id=%s'
            cursor.execute(cursor.mogrify(query, (charge_state, charging_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while update_all_fc_availability", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return

    def reset_chargers(self):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'update "seai".charger set voltage_inst=400, current_inst=0, charging_id=0,' \
                    'fc_availability=true, max_curr=0, charging_mode=false, operator_interr=false,' \
                    'emergency_interr=false, state_occupation=false, new_connection=0, green_power=0'
            cursor.execute(query)
            conn.commit()
        except(Exception, psycopg2.DatabaseError) as error:
            print("Error while reset_chargers()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()

        return

    def clean_historic_charging(self):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'delete from "seai".historic'
            cursor.execute(query)
            conn.commit()
            query = 'delete from "seai".charging'
            cursor.execute(query)
            conn.commit()
        except(Exception, psycopg2.DatabaseError) as error:
            print("Error while clean_historic_charging()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()

        return

    def check_availability(self, charger_id):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'select state_occupation from "seai".charger where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (charger_id, )))
            state_occupation = cursor.fetchall()[0][0]
            state_occupation_int = 0
            if state_occupation:
                state_occupation_int = 1
            else:
                state_occupation_int = 0
            # state_occupation_int = 1 if state_occupation else 0
        except(Exception, psycopg2.DatabaseError) as error:
            print("Error while check_availability()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()

        return state_occupation_int

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

    def update_charger_measures(self, voltage, current, charger_id, max_curr):
        # print(voltage, current, charger_id, max_curr)
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'update "seai".charger set voltage_inst=%s, current_inst=%s, max_curr=%s where charger_id=%s'
            cursor.execute(cursor.mogrify(query, (voltage, current, max_curr, charger_id)))
            conn.commit()

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating charger table 1", error)

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
            print("Error while updating charger table 2", error)

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
            print("Error while updating charger table 3", error)

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
            print("Error while updating charger table 5", error)

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
            print("Error while updating charger table 6", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return new_power

    def get_avg_power2(self, charging_id, total_time, actual_time):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            # CÁLCULO POTÊNCIA MÉDIA
            query = 'select avg_power from "seai".charging where id=%s'
            cursor.execute(cursor.mogrify(query, (charging_id,)))
            power_avg = float(cursor.fetchone()[0])
            query = 'select current_inst from "seai".charger where charging_id=%s'
            cursor.execute(cursor.mogrify(query, (charging_id,)))
            row = cursor.fetchall()[0]
            power_atual = float(row[0])

            new_power = power_atual * actual_time / total_time + \
                        power_avg * (1 - actual_time / total_time)


        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while updating charger table 7", error)

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
            print("Error while get_active_chargers_id()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return charger_id

    def get_all_chargers_id(self):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            query = 'select charger_id from "seai".charger'
            cursor.execute(query)
            # print(cursor.fetchall())
            charger_id = []
            for row in cursor.fetchall():
                # print(row)
                charger_id.append(row[0])
                # print(charger_id)

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while get_all_chargers_id()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return charger_id

    def get_total_cost(self, charging_id):
        # para efeitos de simulação 1s=1min

        try:
            conn = self.connect()
            cursor = conn.cursor()

            now = datetime.now()
            delta_time = self.get_total_interval(charging_id, now)

            query = 'select avg_power, priceper_kwh from "seai".charging where id=%s'
            cursor.execute(cursor.mogrify(query, (charging_id,)))

            row = cursor.fetchall()[0]
            ppkwh = float(row[1])
            power = float(row[0])

            # DESCOMENTAR SE SIMULAÇÃO
            total_cost = round(ppkwh * power / 1000 * delta_time / 60, 2)

            # DESCOMENTAR SE REAL
            # total_cost = round(ppkwh * power / 1000 * delta_time / 3600, 2)
        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while get_total_cost()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return total_cost

    def get_price_pkwh(self, charger_id, fc, green):
        try:
            conn = self.connect()
            cursor = conn.cursor()

            # check if its either green or fast-charging
            if fc:
                query = 'select priceper_kwh_fc from "seai".charger where charger_id=%s'
                query = cursor.mogrify(query, (charger_id, ))
            elif green == 1:
                query = 'select priceper_kwh_green from "seai".charger where charger_id=%s'
                query = cursor.mogrify(query, (charger_id, ))
            else:
                query = 'select priceper_kwh from "seai".charger where charger_id=%s'
                query = cursor.mogrify(query, (charger_id,))

            cursor.execute(query)
            row = cursor.fetchall()[0]

            price = round(row[0], 2)

        except (Exception, psycopg2.DatabaseError) as error:
            print("Error while get_price_pkwh()", error)

        finally:
            if conn:
                cursor.close()
                conn.close()
        return price

