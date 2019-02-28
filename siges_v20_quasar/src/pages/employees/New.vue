<template>
  <q-page padding>
    <q-field
      icon="fingerprint"
      :error="errors.has('cpfcnpj')"
      :error-label="errors.first('cpfcnpj')">
      <q-input
        autofocus
        id="cpfcnpj"
        float-label="CPF/CNPJ"
        type="text"
        v-model.trim="register.employeeCpfCnpj">
      </q-input>
    </q-field>

    <br>
        
    <q-field
      icon="face"
      :error="errors.has('name')"
      :error-label="errors.first('name')">
      <q-input
        id="name"
        float-label="Nome completo"
        type="text"
        v-model.trim="register.employeeName">
      </q-input>
    </q-field>
        
    <br>
        
    <q-field
      icon="call"
      :error="errors.has('phone')"
      :error-label="errors.first('phone')">
      <q-input
        id="phone"
        float-label="Telefone"
        type="text"
        v-model.trim="register.employeePhone">
      </q-input>
    </q-field>
        
    <br>

    <q-field
      icon="phone_android"
      :error="errors.has('mobile')"
      :error-label="errors.first('mobile')">
      <q-input
        id="mobile"
        float-label="Celular"
        type="text"
        v-model.trim="register.employeeMobile">
      </q-input>
    </q-field>

    <br>
        
    <q-field
      icon="mail"
      :error="errors.has('email')"
      :error-label="errors.first('email')">
      <q-input
        id="email"
        float-label="e-mail"
        type="text"
        v-model.trim="register.employeeEmail">
      </q-input>
    </q-field>
        
    <br>
        
    <q-card inline style="width: 100%">
      <q-card-title>
        <gmap-autocomplete
          :options="{            
            componentRestrictions: {'country': ['br']}
          }"
          @place_changed="setPlace"
          placeholder="Localizar endereço"
          float-label="Localizar endereço"
          size="sm">
        </gmap-autocomplete>
        <q-btn
          :label="btnSubmitLabelGMaps"
          glossy
          color="primary"
          align="center"
          size="sm"
          @click="showMarker"
        />              
      </q-card-title>
        
      <q-card-media>
        <gmap-map
          :center="center"
          :zoom="10"
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
      </q-card-media>
          
      <q-card-main>
        <q-field
          icon="mail"
          :error="errors.has('building_comments')"
          :error-label="errors.first('building_comments')">
          <q-input
            id="building_comments"
            float-label="Complemento (Casa, Apto, Sala)"
            type="text"
            v-model.trim="register.employeeBuildingComments">
          </q-input>
        </q-field>
      </q-card-main>
         
      <q-card-actions>
      </q-card-actions>
    </q-card>
    
    <br><br>
    
    <q-btn
      :loading="loading"
      :disable="loading"
      :label="btnSubmitLabel"
      glossy
      color="primary"
      align="center"
      size="md"
      @click="onSubmit"
    />
  </q-page>
</template>

<script>
  import axios from 'axios';
  import { CONFIG } from '../../config';
  
  export default {
    name: "EmployeeRegister",
    data() {
      return {
        register: {
          employeeCpfCnpj: '',
          employeeName: '',
          employeeAddress: '',
          employeeBuilding: '',
          employeeBuildingComments: '',
          employeeNeighborhood: '',
          employeeZipCode: '',
          employeeCity: '',
          employeeState: '', 
          employeePhone: '',
          employeeMobile: '',
          employeeEmail: '',
          employeeComments: ''
        },
        // default to Montreal to keep it simple
        // change this to whatever makes sense
        loading: false,
        btnSubmitLabelGMaps: "Buscar",
        btnSubmitLabel: "Confirmar",
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
        
        this.register.employeeLat = marker.lat;
        this.register.employeeLng = marker.lng;

        //console.log(this.register.employeeLat, this.register.employeeLng);
      },
      showMarker() {
        if (this.currentPlace) {
          const marker = {
            lat: this.currentPlace.geometry.location.lat(),
            lng: this.currentPlace.geometry.location.lng()
          }

          this.register.employeeLat = marker.lat;
          this.register.employeeLng = marker.lng;

          this.register.employeeAddress = this.currentPlace.address_components[1].short_name;
          this.register.employeeBuilding = this.currentPlace.address_components[0].short_name;
          this.register.employeeNeighborhood = this.currentPlace.address_components[2].long_name;
          this.register.employeeZipCode = this.currentPlace.address_components[6].long_name;
          this.register.employeeCity = this.currentPlace.address_components[3].long_name;
          this.register.employeeState = this.currentPlace.address_components[4].short_name;
          
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
        this.register.employeeLat = center.lat;
        this.register.employeeLng = center.lng;
      },
      onSubmit() {
        const data = { 
          cpfcnpj: this.register.employeeCpfCnpj,
          name: this.register.employeeName,
          address: this.register.employeeAddress,
          building: this.register.employeeBuilding,
          building_comments: this.register.employeeBuildingComments,
          zip_code: this.register.employeeZipCode,
          neighborhood: this.register.employeeNeighborhood,
          city: this.register.employeeCity,
          state: this.register.employeeState,
          phone: this.register.employeePhone,
          mobile: this.register.employeeMobile,
          email: this.register.employeeEmail,
          lat: this.register.employeeLat,
          lng: this.register.employeeLng
        };

        console.log(data);

        return axios.post(CONFIG.api_url + '/employees', data)
          .then((response) => {
            this.employee = response.data.employee;
            data.id = this.employee.id;
            
            this.$store.dispatch('employees/actEmployeeAdd', data);

            this.$router.push('/employees/' + this.employee.id);
          })
          .catch(errors => {
            console.log('errors: ', errors.response);
            if (errors.response.status === 422) {
              this.$setErrorsFromResponse(errors.response.data);

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

