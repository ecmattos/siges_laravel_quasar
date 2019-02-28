<template>
  <q-layout>
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:10px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Nova Senha de Acesso
          </p>
          <q-card-media>
            
          </q-card-media>
        </q-card-title>

        <q-card-main>
          <form>
            <div class="text-left q-pa-sm">
              <q-field
                icon="lock"
                :error="errors.has('codeVerification')"
                :error-label="errors.first('codeVerification')"
                >
                  <q-input
                    id="codeVerification"
                    float-label="Código verificação"
                    type="text"
                    v-model.trim="credentials.codeVerification"
                    autofocus
                  />
              </q-field>

              <br>
              
              <q-field
                icon="lock"
                :error-label="errors.first('password')"
                :error="errors.has('password')"
              >
                <q-input
                  id="password"
                  float-label="Senha"
                  type="password"
                  v-model.trim="credentials.password"
                />
              </q-field>

              <br>

              <q-field
                icon="lock"
                :error-label="errors.first('passwordRepeat')"
                :error="errors.has('passwordRepeat')"
              >
                <q-input
                  id="passwordRepeat"
                  float-label="Repetir senha"
                  type="password"
                  v-model.trim="credentials.passwordRepeat"
                />
              </q-field>

              <br>

              <q-btn
                :loading="submiting"
                :disable="submiting"
                :label="btnSubmitLabel"
                class="full-width"
                color="primary"
                @click.prevent="onSubmit()">
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
        <q-tab two-lines label="Senha" slot="title" name="tabRecovery" icon="contact_mail" @click="tabRecoverySelected"/>
      </q-tabs>
    </q-layout-footer>    
  </q-layout>

</template>

<script>
  import axios from 'axios';
  import { CONFIG } from '../../config';
  import { SessionStorage } from 'quasar';

  export default {
    data () {
      return {
        credentials: {
          codeVerification: '',
          password: '',
          passwordRepeat: ''
        },
        submiting: false,
        btnSubmitLabel: "Confirmar"
      }
    },

    mounted(){
      this.$store.dispatch('auth/actPageSet', ['REGISTRO', 'Crie uma nova conta']);
    },

    computed: {
    },

    methods: {
      tabLoginSelected() {
        this.tabSelected = 'tabLogin';
        this.$router.push('/login');
      },

      tabRecoverySelected() {
        // alert('Motor')
        this.tabSelected = 'tabRecovery';
        this.$router.push('/recovery');
      },

      onSubmit () {        
        this.submiting = true;
        this.btnSubmitLabel = "Verificando...";
        
        axios.post(CONFIG.api_url + '/auth/reset', this.credentials)
          .then((response) => {
            this.$q.notify({
              message: 'Senha de Acesso alterada ! ',
              icon: 'thumb_up_alt',
              position: 'top-right',
              type: 'positive'
            });
            
            this.$router.push('/login');
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
      }
    }
  }
</script>