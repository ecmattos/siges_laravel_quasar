import * as VueGoogleMaps from 'vue2-google-maps';

// leave the export, even if you don't use it
export default ({ Vue }) => {
  Vue.use(VueGoogleMaps, {
    load: {
      key: "AIzaSyDBSMev2CrrxQJQlWMUVqTLg0VXvN7qfSw",
      libraries: "places" // necessary for places input
    }
  })
}
