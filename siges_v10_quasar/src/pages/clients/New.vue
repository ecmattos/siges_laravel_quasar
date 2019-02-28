<template>
  <q-layout>
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: auto; padding:1px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Informe seus dados
          </p>
        </q-card-title>

        <q-card-main>
          <form>
            <div class="text-left q-pa-sm">
              <q-field 
                icon="assignment"
                :error-label="errors.first('cpfcnpj')"
                :error="errors.has('cpfcnpj')"
              >
                <q-input
                  id="cpfcnpj"
                  float-label="CPF ou CNPJ"
                  type="text"
                  v-model.trim="client.cpfcnpj"
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
                  float-label="Nome ou Razão Social"
                  type="text"
                  v-model.trim="client.name"
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
                  v-model.trim="client.email"
                />
              </q-field>
              
              <br>

              <q-card-separator />

              <q-btn
                :loading="submiting"
                :disable="submiting"
                :label="btnSubmitLabel"
                class="full-width"
                color="primary"
                @click="onSubmit ()">
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
  import axios from 'axios'
  import { CONFIG } from '../../config'

  export default {
    data () {
      return {
        client: {
          cpfcnpj: '',
          name: '',
          email: ''
        },
        submiting: false,
        btnSubmitLabel: "Enviar"
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
        this.submiting = true;
        this.btnSubmitLabel = "Verifcando...";

        //this.$q.loadingBar.start();
        this.$q.loading.show({
          spinner: 'QSpinnerGears',
          message: 'Estamos verificando seus dados... Favor aguardar.',
          messageColor: 'white',
          spinnerSize: 100, // in pixels
          spinnerColor: 'white',
          customClass : ''
        });
       
        console.log(this.client);
        axios.post(CONFIG.api_url + '/clients', this.client)
          .then(response => {
            this.$router.push('/clients/userAdminRegister');

            this.submiting = false;
            this.btnSubmitLabel = "Verificado";
          
            this.$q.notify({
              message: 'Obrigado! Verifique o seu e-mail para finalizar o seu cadastro.',
              icon: 'thumb_up_alt',
              position: 'top-right',
              type: 'positive'
            });

            //this.$q.loadingBar.stop();
            this.$q.loading.hide();

          }).catch(errors => {
            if (errors.response.status == 400) {
              this.$setErrorsFromResponse(errors.response.data);

              this.submiting = false;
              this.btnSubmitLabel = "Enviar";

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
              //this.$q.loadingBar.stop();
              this.$q.loading.hide();
            }
          });
      }
    }
  }
</script>