<template>
  <q-page padding class="docs-input row justify-center">
    <div style="width: 500px; max-width: 90vw;">
      <q-field
        icon="fingerprint"
        :error="errors.has('cpfcnpj')"
        :error-label="errors.first('cpfcnpj')">
        <q-input
          autofocus
          id="cpfcnpj"
          float-label="CPF/CNPJ"
          type="text"
          v-model.trim="register.customerCpfCnpj">
        </q-input>
      </q-field>

      <q-field
        icon="face"
        :error="errors.has('name')"
        :error-label="errors.first('name')">
        <q-input
          id="name"
          float-label="Nome completo"
          type="text"
          v-model.trim="register.customerName">
        </q-input>
      </q-field>
          
      <q-field
        icon="call"
        :error="errors.has('phone')"
        :error-label="errors.first('phone')">
        <q-input
          id="phone"
          float-label="Telefone"
          type="text"
          v-model.trim="register.customerPhone">
        </q-input>
      </q-field>
          
      <q-field
        icon="phone_android"
        :error="errors.has('mobile')"
        :error-label="errors.first('mobile')">
        <q-input
          id="mobile"
          float-label="Celular"
          type="text"
          v-model.trim="register.customerMobile">
        </q-input>
      </q-field>

      <q-field
        icon="mail"
        :error="errors.has('email')"
        :error-label="errors.first('email')">
        <q-input
          id="email"
          float-label="e-mail"
          type="text"
          v-model.trim="register.customerEmail">
        </q-input>
      </q-field>

      <q-field>
        <gmap-autocomplete
          :options="{            
            componentRestrictions: {'country': ['br']}
          }"
          @place_changed="setPlace"
          placeholder="Informar endereço"
          float-label="Infirmar endereço"
          size="sm"
          style="width: 100%">
        </gmap-autocomplete>
        <q-btn
          class="full-width"
          :label="btnSubmitLabelGMaps"
          glossy
          icon="gps_fixed"
          color="primary"
          align="center"
          size="md"
          @click="showMarker"
        />  

        <gmap-map
          :center="center"
          :zoom="17"
          style="width:100%;  height: 400px;">
          <gmap-marker
            :key="index"
            v-for="(m, index) in markers"
            :position="m.position"
            @position_changed="m.position=$event"
            @click="center=m.position"
            :draggable="true"
            @drag="getMarkerDragPosition($event)">
          </gmap-marker>
        </gmap-map>
      </q-field>

      <q-field
        icon="mail"
        :error="errors.has('building_comments')"
        :error-label="errors.first('building_comments')">
        <q-input
          id="building_comments"
          float-label="Complemento (Casa, Apto, Sala)"
          type="text"
          v-model.trim="register.customerBuildingComments">
        </q-input>
      </q-field>

      <q-btn
        :loading="submiting"
        :disable="submiting"
        :label="btnSubmitLabel"
        glossy
        color="primary"
        align="center"
        size="md"
        @click="onSubmit"
      />
    </div>
  </q-page>
</template>

<script>
  import '../../css/themes/docs-input.styl'
  import axios from 'axios';
  import { CONFIG } from '../../config';
  
  export default {
    name: "CustomerRegister",
    data() {
      return {
        register: {
          customerCpfCnpj: '',
          customerName: '',
          customerAddress: '',
          customerBuilding: '',
          customerBuildingComments: '',
          customerNeighborhood: '',
          customerZipCode: '',
          customerCity: '',
          customerState: '', 
          customerPhone: '',
          customerMobile: '',
          customerEmail: '',
          customerComments: ''
        },
        // default to Montreal to keep it simple
        // change this to whatever makes sense
        submiting: false,
        btnSubmitLabel: "Confirmar",
        btnSubmitLabelGMaps: "Localizar",
        center:[],
        markers: [],
        places: [],
        currentPlace: null
      }
    },
    mounted() {
      this.$store.dispatch('auth/actPageSet', ['CLIENTE', 'Inclusão']);
      this.geolocate();
    },

    methods: {
      // receives a place object via the autocomplete component
      setPlace(place) {
        //console.log(place)
        this.currentPlace = place
      },
      getMarkerDragPosition (position) { 
        const marker = {          
          lat: position.latLng.lat(),
          lng: position.latLng.lng()
        }
        
        this.register.customerLat = marker.lat;
        this.register.customerLng = marker.lng;

        //console.log(this.register.customerLat, this.register.customerLng);
      },
      showMarker() {
        if (this.currentPlace) {
          const marker = {
            lat: this.currentPlace.geometry.location.lat(),
            lng: this.currentPlace.geometry.location.lng()
          }

          this.register.customerLat = marker.lat;
          this.register.customerLng = marker.lng;

          this.register.customerAddress = this.currentPlace.address_components[1].short_name;
          this.register.customerBuilding = this.currentPlace.address_components[0].short_name;
          this.register.customerNeighborhood = this.currentPlace.address_components[2].long_name;
          this.register.customerZipCode = this.currentPlace.address_components[6].long_name;
          this.register.customerCity = this.currentPlace.address_components[3].long_name;
          this.register.customerState = this.currentPlace.address_components[4].short_name;
          
          this.markers.push({ position: marker });
        
          this.center = marker;

          this.places.push(this.currentPlace);
          //this.currentPlace = null          
        }
      },
      addMarker() {
        this.places.push(this.currentPlace);
        this.currentPlace = null;
      },
      geolocate: function() {
        navigator.geolocation.getCurrentPosition(position => {
          this.center = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
        });
        this.register.customerLat = center.lat;
        this.register.customerLng = center.lng;
      },
      onSubmit() {
        const DATA = { 
          cpfcnpj: this.register.customerCpfCnpj,
          name: this.register.customerName,
          address: this.register.customerAddress,
          building: this.register.customerBuilding,
          building_comments: this.register.customerBuildingComments,
          zip_code: this.register.customerZipCode,
          neighborhood: this.register.customerNeighborhood,
          city: this.register.customerCity,
          state: this.register.customerState,
          phone: this.register.customerPhone,
          mobile: this.register.customerMobile,
          email: this.register.customerEmail,
          lat: this.register.customerLat,
          lng: this.register.customerLng
        };

        //console.log("data: ", DATA);

        axios.post(CONFIG.api_url + '/customers', DATA)
          .then((response) => {
            this.submiting = true;
            this.btnSubmitLabel = "Verificando...";
            
            let customer = response.data.customer;
            console.log('customer: ', customer);
            //let customerId = this.customer.id;
            //console.log('customerId: ', customerId);
            
            this.$store.dispatch('customers/actCustomerAdd', customer);

            this.submiting = false;
            
            this.$store.dispatch('auth/actPageSet', ['CLIENTE', 'Consulta']);
            //this.$router.push({path: '/customers/' + customerId});
          })
          .catch(errors => {
            //console.log("errors ", errors.response.data.error.status_code);
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


<style scope>
  
</style>


