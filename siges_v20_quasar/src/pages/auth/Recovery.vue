<template>
  <q-layout>
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:10px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Esqueceu a Senha ?
          </p>
          <q-card-media>
            
          </q-card-media>
        </q-card-title>

        <q-card-main>
          <form>
            <div class="text-left q-pa-sm">
              <q-field
                icon="mail"
                :error="errors.has('email')"
                :error-label="errors.first('email')"
              >
                <q-input
                  id="email"
                  float-label="E-mail"
                  type="text"
                  v-model.trim="credentials.email"
                />
              </q-field>
                
              <br>

              <q-btn
                :loading="submiting"
                :disable="submiting"
                :label="btnSubmitLabel"
                class="full-width"
                color="primary"
                @click="onSubmit()">
              </q-btn>
              
              <br>
            </div>
          </form>
        </q-card-main>
      </q-card>
    </div>

    <q-layout-footer>
      <q-tabs align="center">
        <!-- Tabs - notice slot="title" -->
        <q-tab two-lines label="Login" slot="title" name="tabLogin" icon="how_to_reg" @click="tabLoginSelected"/>
        <q-tab two-lines label="Conta" slot="title" name="tabRegister" icon="person_add" @click="tabRegisterSelected"/>
      </q-tabs>
    </q-layout-footer>    
  </q-layout>
</template>


<script>
  import axios from 'axios';
  import { CONFIG } from '../../config';

  export default
  {
    data () {
      return {
        credentials: {
          email: ''
        },
        submiting: false,
        btnSubmitLabel: "Confirmar"
      }
    },

    mounted(){
      this.$store.dispatch('auth/actPageSet', ['RECUPERAÇÂO DA SENHA', 'Recupere a sua senha de acesso']);  
    },

    methods : {
      tabLoginSelected() {
        this.tabSelected = 'tabLogin';
        this.$router.push('/login');
      },

      tabRegisterSelected() {
        this.tabSelected = 'tabRegister';
        this.$router.push('/signup');
      },
      
      onSubmit() {
        this.$q.loadingBar.start();

        this.submiting = true;
        this.btnSubmitLabel = "Verificando...";

        axios.post(CONFIG.api_url + '/auth/recovery', this.credentials)
          .then(response => {
            
            this.submiting = false;
            this.btnSubmitLabel = "Verificado";
          
            this.$q.notify({
              message: 'Instruções enviadas para o e-mail informado.',
              icon: 'thumb_up_alt',
              position: 'top-right',
              type: 'positive'
            });

            this.$q.loadingBar.stop();
            this.$router.push({ path: '/reset' });
          })
          .catch(errors => {
            if (errors.response.data.error.status_code === 422) {
              this.$setErrorsFromResponse(errors.response.data.error);

              this.submiting = false;
              this.btnSubmitLabel = "Confirmar";

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
            }
          });

        this.$q.loadingBar.stop();
      }
    }
  }
</script>

<style>
</style>


