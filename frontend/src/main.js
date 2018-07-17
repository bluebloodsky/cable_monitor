// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import axios from './http'
import App from './App'
import router from './router'
import store from './store'
import Date from './shared/extend'

import {getRandomFloat} from './shared/util'
if (process.env.NODE_ENV == 'development') {
  Vue.prototype.cfgInfo = cfgInfo['development']
} else {
  Vue.prototype.cfgInfo = cfgInfo['production']
}

/*
let strs = ''

//SPDC
{

  let maxK = 2
  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k
        strs += "('" + 'jfd' + id + "','" + id + "#','" + "SPDC','500_xiaxun1','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k + 30 * maxK
        strs += "('" + 'jfd' + id + "','" + id + "#','" + "SPDC','500_xiaxun2','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

}
//GILC
{

  let maxK = 3
  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < 4; k++) {
        let id = i * maxK * 10 + j * maxK + k
        strs += "('" + 'gil' + id + "','" + id + "#','" + "GILC','500_xiafeng1','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k + 30 * maxK
        strs += "('" + 'gil' + id + "','" + id + "#','" + "GILC','500_xiafeng2','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }
}

//SPTR
{

  let maxK = 1
  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k
        strs += "('" + 'zll' + id + "','" + id + "#','" + "SPTR','500_xiaxun1','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k + 30 * maxK
        strs += "('" + 'zll' + id + "','" + id + "#','" + "SPTR','500_xiaxun2','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

}


//SSBH
{

  let maxK = 1
  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k
        strs += "('" + 'jyjs' + id + "','" + id + "#','" + "SSBH','500_xiaxun1','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k + 30 * maxK
        strs += "('" + 'jyjs' + id + "','" + id + "#','" + "SSBH','500_xiaxun2','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

}


//STMP
{

  let maxK = 1
  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k
        strs += "('" + 'gxcw' + id + "','" + id + "#','" + "STMP','500_xiaxun1','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 10; j++) {
      for (let k = 1; k < maxK + 1; k++) {
        let id = i * maxK * 10 + j * maxK + k + 30 * maxK
        strs += "('" + 'gxcw' + id + "','" + id + "#','" + "STMP','500_xiaxun2','fangqu" + (j + 1) + "','" + (i + 1) + "',25.0144,58.9095),"
      }
    }
  }

}


//ENVR
{

  let maxK = 5
  for (let j = 0; j < 10; j++) {
    for (let k = 1; k < maxK + 1; k++) {
      let id = j * maxK + k
      strs += "('" + 'hj' + id + "','" + id + "#','" + "ENVR',null,'fangqu" + (j + 1) + "',null,25.0144,58.9095),"
    }
  }

}


console.log(strs)
*/


/*
let strs = ''

//zll

for (let i = 1; i < 501; i++) {
  strs += "(" + (i*3 + 1) + ",'hj" + i + "','gasTmp'),"
  strs += "(" + (i*3 + 2) + ",'hj" + i + "','humity'),"
  strs += "(" + (i*3 + 3) + ",'hj" + i + "','fog'),"
}

for (let i = 1; i < 61; i++) {
  strs += "(" + (10000 + i) + ",'zll" + i + "','TotCurrent'),"
}

for (let i = 1; i < 121; i++) {
  strs += "(" + (20000 + i) + ",'jfd" + i + "','AppPaDsch'),"
}

for (let i = 1; i < 181; i++) {
  strs += "(" + (30000 + i) + ",'gil" + i + "','AppPaDsch'),"
}


for (let i = 1; i < 61; i++) {
  strs += "(" + (40000 + i) + ",'jyjs" + i + "','LosFact'),"
}

for (let i = 1; i < 61; i++) {
  strs += "(" + (50000 + i) + ",'gxcw" + i + "','Temp'),"
}

*/

let strs = ''




// for (let i = 1; i < 61; i++) {
//   strs += "(" + (10000 + i) + ",'zll" + i + "','TotCurrent'),"
// }

// for (let i = 1; i < 121; i++) {
//   strs += "(" + (20000 + i) + ",'jfd" + i + "','AppPaDsch'),"
// }

// for (let i = 1; i < 181; i++) {
//   strs += "(" + (30000 + i) + ",'gil" + i + "','AppPaDsch'),"
// }


// for (let i = 1; i < 61; i++) {
//   strs += "(" + (40000 + i) + ",'jyjs" + i + "','LosFact'),"
// }

// for (let i = 1; i < 61; i++) {
//   strs += "(" + (50000 + i) + ",'gxcw" + i + "','Temp'),"
// }

// for (let i = 1; i < 61; i++) {
//   strs += "(" + (50000 + i) + ",'gxcw" + i + "','Temp'),"
// }

console.log(strs)

Vue.config.productionTip = true
/* eslint-disable no-new */
Vue.prototype.axios = axios
let vm = new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
