<template>
  <q-layout>
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="auto; padding:1px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Informe dados do Usuário Administrador
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
                icon="face"
                :error-label="errors.first('name')"
                :error="errors.has('name')"
              >
                <q-input
                  id="name"
                  float-label="Nome"
                  type="text"
                  v-model.trim="credentials.name"
                />
              </q-field>
                
              <br>
              
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
                :loading="loading"
                :disable="loading"
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
        <q-tab two-lines label="Código Ativação" slot="title" name="tabVerify" icon="person_add" @click="tabVerifySelected"/>
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
          name: '',
          email: '',
          password: '',
          passwordRepeat: ''
        },
        loading: false,
        btnSubmitLabel: "Enviar",
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

      tabVerifySelected() {
        this.tabSelected = 'tabVerify';
        this.$router.push('/verify');
      },
      
      tabRecoverySelected() {
        // alert('Motor')
        this.tabSelected = 'tabRecovery';
        this.$router.push('/recovery');
      },

      onSubmit () {        
        this.onSubmitting();

        axios.post(CONFIG.api_url + '/registerAdmin', this.credentials)
          .then((response) => {
            this.$router.push('/dashboard');
            this.$q.notify({
              message: 'Obrigado pela finalização do seu cadastro ! ',
              icon: 'thumb_up_alt',
              position: 'top-right',
              type: 'positive'
            });
            this.onSubmitted();

            axios.post(CONFIG.api_url + '/login', this.credentials)
            .then(response => {
              let token = response.data.access_token.token;
              SessionStorage.set('token', token);
              
              let user = response.data.user;
              SessionStorage.set('user', user);

              this.$store.dispatch('auth/actUserLogged', user);
              
              this.$store.dispatch('auth/actPageSet', ['Painel de Controle', 'Visão Geral']);
              this.$router.push({ path: '/dashboard' });
            });

          })
          .catch(errors => {
            console.log('errors: ', errors.response);
            if (errors.response.status === 400) {
              this.$setErrorsFromResponse(errors.response.data);

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });

              this.onSubmitted();
            }
          });
      },

      onSubmitting() {
        this.loading = true;
        this.btnSubmitLabel = "Pesquisando...";
        //this.$q.loadingBar.start();
        this.$q.loading.show({
          spinner: 'QSpinnerGears',
          message: 'Estamos finalizando a configuração da sua conta... favor aguardar.',
          messageColor: 'white',
          spinnerSize: 100, // in pixels
          spinnerColor: 'white',
          customClass : ''
        });
      },

      onSubmitted() {
        this.loading = false;
        this.btnSubmitLabel = "Enviar";
        //this.$q.loadingBar.stop();
        this.$q.loading.hide();
      }

    }
  }
</script>