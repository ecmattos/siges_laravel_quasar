<template>
  <q-page padding>  
    
    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-btn round color="primary" to="/materials/new" icon="add" />
    </q-page-sticky>

    <q-tabs>
      <!-- Tabs - notice slot="title" -->
      <q-tab default two-lines label="Descrição" slot="title" name="tabSrcDescription" icon="fa fa-edit" @click="tabSrcDescriptionSelected"/>
      <q-tab two-lines label="Código" slot="title" name="tabSrcCode" icon="fa fa-barcode" @click="tabSrcCodeSelected"/>
      <q-tab disable two-lines label="Avançada" slot="title" name="tabSrcAvanced" icon="fa fa-cogs" @click="tabSrcAvancedSelected"/>
    </q-tabs>

    <q-card
      inline style="width: 100%"
      text-color="dark"
      >

      <q-card-title>
      </q-card-title>

      <q-card-main>
        <q-field
          v-if="selectedTab === 'tabSrcDescription'"
          icon-color="dark"
          color-label="primary"
          helper="(Tipo, marca, modelo, serial, código)"
          :error="errors.has('description_terms')"
          :error-label="errors.first('description_terms')"
        >
          <q-chips-input
            autofocus
            float-label="Informe algumas características"
            type="text"
            v-model="search.description_terms"
          />
        </q-field>

        <q-field
          v-else-if="selectedTab === 'tabSrcCode'"
          icon-color="dark"
          color-label="primary"
          helper="(Código de identificação)"
          :error="errors.has('description_terms')"
          :error-label="errors.first('description_terms')"
        >
          <q-chips-input
            autofocus
            float-label="Informe o Código"
            type="number"
            v-model="search.description_terms"
          />
        </q-field>
      </q-card-main>

      <q-card-separator/>

      <q-card-actions>
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
      </q-card-actions>
    </q-card>

    <hr>

    <q-list highlight striped-odd dense no-border>
      <q-item multiline v-for="(material, index) in materialsSearch" :key="index" :to="'/materials/'+material.id">
        <q-item-side avatar="assets/img/user_default.png">
        </q-item-side>
        <q-item-main>
          <q-item-tile label-lines="1" label>{{ material.code }}</q-item-tile>
          <q-item-tile sublabel-lines="2" sublabel>{{ material.description }} ({{ material.material_unit.code }}) </q-item-tile>
        </q-item-main>
        <q-item-side right>          
          <q-item-tile v-for="(warehouse, index) in  material.warehouse" :key="index">
            {{ material.warehouse[index].description }}: 
            <q-chip small color="primary">{{ material.material_supply[index].qty }}</q-chip>
          </q-item-tile>
        </q-item-side>
      </q-item>
    </q-list>

  </q-page>
</template>

<script>
  import axios from 'axios';
  import { CONFIG } from '../../config';
  
  export default {
    data() {
      return {
        loading: false,
        btnSubmitLabel: "Pesquisar",
        search: {
          description_terms: []
        },
        selectedTab: 'tabSrcDescription'
      }
    },
    mounted(){
      this.$store.dispatch('auth/actPageSet', ['MATERIAIS', 'Pesquisa']);
    },
    methods: {
      onSubmit () {        
        this.onSubmitting();

        //console.log('PARAMS', this.search.description_terms)
        if(this.selectedTab == 'tabSrcDescription')
        {
          return axios.post(CONFIG.api_url + '/materials/searchDescription', this.search)
            .then((response) => {
              console.log('srch_materials: ',response.data.materials);
              this.materials = response.data.materials;
              console.log('materials: ', this.materials);
              this.$store.dispatch('materials/actMaterialsSearchDescription', this.materials || []);

              this.onSubmitted();
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
        }

        if(this.selectedTab == 'tabSrcCode')
        {
          axios.post(CONFIG.api_url + '/materials/searchCode', this.search)
            .then((response) => {
              this.materials = response.data.materials;
              this.$store.dispatch('materials/actMaterialsSearchCode', this.materials || []);
            })
            .catch(errors => {
            //console.log(errors.status)
            if (errors.response.status === 400) {
              this.$setErrorsFromResponse(errors.response.data);

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
            }
          });
        }        
      },

      openProduct(data){
        //console.log(data)
        this.$router.push('/materials/' + data.id);
      },

      paginationLabel(start, end, total){
        return start + ' até ' + end + ' de ' + total;
      },

      tabSrcDescriptionSelected(){
        this.selectedTab = 'tabSrcDescription';
      },

      tabSrcCodeSelected(){
        this.selectedTab = 'tabSrcCode';
      },

      tabSrcAvancedSelected(){
        this.selectedTab = 'tabSrcAvanced';
      },

      onSubmitting() {
        this.loading = true;
        this.btnSubmitLabel = "Pesquisando...";
        this.$q.loadingBar.start();
      },

      onSubmitted() {
        this.loading = false;
        this.btnSubmitLabel = "Pesquisar";
        this.$q.loadingBar.stop();
      }
    },
    computed: {
      materialsSearch() {
        return this.$store.getters['materials/getMaterialsSearch'];   
      }
    }
  }
</script>

<style>
</style>
