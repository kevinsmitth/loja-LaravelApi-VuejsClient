import Vuetify from 'vuetify/lib'

import colors from 'vuetify/lib/util/colors'

const vuetify = new Vuetify({
  theme: {
    light: true,
    options: {
      customProperties: true,
    },
    themes: {
      light: {
        background: '#f5f3f4',
        primary: colors.purple,
        secondary: colors.grey.darken1,
        accent: colors.shades.black,
        error: colors.red.accent3,
      },
      dark: {
        background:'#1C1C1C',
        primary: colors.blue.lighten3,
        secondary: colors.grey.lighten1,
        accent: colors.shades.light,
        error: colors.red.accent3,
      },
    },
  },
})


export default vuetify
