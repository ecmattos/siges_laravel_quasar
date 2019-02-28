import * as VueGoogleMaps from 'vue2-google-maps';

// leave the export, even if you don't use it
export default ({ Vue }) => {
  Vue.use(VueGoogleMaps, {
    load: {
      key: "AIzaSyBVvIL8ZHvUOaV_Hebr6YpK3NIpIUfuXRQ",
      libraries: "places" // necessary for places input
    }
  })
}
