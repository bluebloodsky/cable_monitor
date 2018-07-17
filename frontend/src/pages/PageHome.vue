<template>
  <div>
    <header>
      <div class="logo">
        <img src="../assets/img/logo.png">
        <h1>电缆及通道综合在线监测系统</h1>
      </div>
      <nav>
        <ul>
          <li v-for="(menu,index) in nav_menus">
            <router-link :to="menu.url">
              <i class="iconfont" :class="menu.icon"></i>
              <br/>{{menu.name_cn}}
            </router-link>
          </li>
        </ul>
      </nav>
      <div class="right-info">
        <a> <img src="../assets/img/user.png"></a>
        <span> 
          <strong>{{t}}</strong> 
          <br/>
          {{d}}
        </span>
      </div>
    </header>
    <!--     <transition>
      <keep-alive> -->
    <router-view></router-view>
    <!--       </keep-alive>
    </transition> -->
  </div>
</template>
<script>
import { NAV_MENUS } from '@/shared/constant'
import { getRandomFloat, getRandomInt } from '@/shared/util'
export default {
  data() {
    return {
      nav_menus: [],
      sub_menus: [],
      currentMenuIndex: 0,
      dt: new Date(),
    }
  },
  created() {

    // let strs = ''

    // let dt = new Date()
    // for (let i = 1; i < 101; i++) {
    //   let st = dt.format('yyyy-MM-dd hh:mm:ss')
    //   strs += "(" + (i * 3 + 3) + ",'.fog'," + 0 + ",'" + st + "'),"
    // }

    // for (let i = 1; i < 101; i++) {
    //   let st = dt.format('yyyy-MM-dd hh:mm:ss')
    //   strs += "(" + (i * 3 + 1) + ",'.gasTmp'," + getRandomFloat(25, 28, 1) + ",'" + st + "'),"
    //   strs += "(" + (i * 3 + 2) + ",'.humity'," + getRandomFloat(56, 61, 1) + ",'" + st + "'),"
    // }

    // for (let i = 1; i < 121; i++) {
    //   let st = dt.format('yyyy-MM-dd hh:mm:ss')
    //   strs += "(" + (20000 + i) + ",'.AppPaDsch'," + getRandomFloat(20, 45, 1) + ",'" + st + "'),"
    // }

    // for (let i = 1; i < 181; i++) {
    //   let st = dt.format('yyyy-MM-dd hh:mm:ss')
    //   strs += "(" + (30000 + i) + ",'.AppPaDsch'," + getRandomFloat(20, 45, 1) + ",'" + st + "'),"
    // }

    // for (let i = 1; i < 61; i++) {
    //   let st = dt.format('yyyy-MM-dd hh:mm:ss')
    //   strs += "(" + (10000 + i) + ",'.TotCurrent'," + getRandomFloat(0.5, 0.8, 3) + ",'" + st + "'),"
    // }

    //  for (let i = 1; i < 61; i++) {
    //   let st = dt.format('yyyy-MM-dd hh:mm:ss')
    //   strs += "(" + (40000 + i) + ",'.LosFact'," + getRandomFloat(0.5, 0.8, 3) + ",'" + st + "'),"
    // }

    //  for (let i = 1; i < 61; i++) {
    //   let st = dt.format('yyyy-MM-dd hh:mm:ss')
    //   strs += "(" + (50000 + i) + ",'.Temp'," + getRandomFloat(30, 45, 1) + ",'" + st + "'),"
    // }


    // for (let i = 1; i < 10; i++) {
    //   for (let j = 1; j < 20; j++) {

    //     let dt = new Date()
    //     let st = dt.addDays(-1 * j).format('yyyy-MM-dd hh:mm:ss')
    //     strs += "(" + (i * 3 + 1) + "," + getRandomFloat(25, 28, 1) + ",'" + st + "'),"
    //     strs += "(" + (i * 3 + 2) + "," + getRandomFloat(56, 61, 1) + ",'" + st + "'),"
    //   }
    // }

    // for (let i = 1; i < 10; i++) {
    //   for (let j = 1; j < 20; j++) {
    //     let dt = new Date()
    //     let st = dt.addDays(-1 * j).format('yyyy-MM-dd hh:mm:ss')
    //     strs += "(" + (20000 + i) + "," + getRandomFloat(20, 45, 1) + ",'" + st + "'),"
    //   }
    // }

    // for (let i = 1; i < 10; i++) {
    //   for (let j = 1; j < 20; j++) {
    //     let dt = new Date()
    //     let st = dt.addDays(-1 * j).format('yyyy-MM-dd hh:mm:ss')
    //     strs += "(" + (30000 + i) + "," + getRandomFloat(20, 45, 1) + ",'" + st + "'),"
    //   }
    // }

    // for (let i = 1; i < 10; i++) {
    //   for (let j = 1; j < 20; j++) {
    //     let dt = new Date()
    //     let st = dt.addDays(-1 * j).format('yyyy-MM-dd hh:mm:ss')
    //     strs += "(" + (10000 + i) + "," + getRandomFloat(0.5, 0.8, 3) + ",'" + st + "'),"
    //   }
    // }

    // for (let i = 1; i < 10; i++) {
    //   for (let j = 1; j < 20; j++) {
    //     let dt = new Date()
    //     let st = dt.addDays(-1 * j).format('yyyy-MM-dd hh:mm:ss')
    //     strs += "(" + (40000 + i) + "," + getRandomFloat(0.5, 0.8, 3) + ",'" + st + "'),"
    //   }
    // }

    // for (let i = 1; i < 10; i++) {
    //   for (let j = 1; j < 20; j++) {
    //     let dt = new Date()
    //     let st = dt.addDays(-1 * j).format('yyyy-MM-dd hh:mm:ss')
    //     strs += "(" + (50000 + i) + "," + getRandomFloat(30, 45, 1) + ",'" + st + "'),"
    //   }
    // }

    // console.log(strs)

    this.nav_menus = NAV_MENUS
    this.axios.get("device-cfg").then(response => {
      let tunnels = response.data['tunnels']
      let wires = response.data['wires']
      let monitor_types = response.data['monitor_types']
      let sections = response.data['sections']
      let monitor_params = response.data['monitor_params']
      let monitor_devices = response.data['monitor_devices']

      this.$store.commit('editMonitorTypes', monitor_types)
      this.$store.commit('editTunnels', tunnels)
      this.$store.commit('editSections', sections)
      this.$store.commit('editWires', wires)
      this.$store.commit('editMonitorParams', monitor_params)
      this.$store.commit('editMonitorDevices', monitor_devices)
    })

    window.setInterval(() => {
      this.dt = new Date()
    }, 1000)

  },
  computed: {
    t() {
      return this.dt.format("hh:mm:ss")
    },
    d() {
      return this.dt.format("yyyy-MM-dd")
    }
  },
  methods: {
    onNavClick(menu, index) {
      this.sub_menus = menu.sub_menus
      this.$router.push(menu.url)
      this.currentMenuIndex = index
    }
  }
}

</script>
<style scoped>
header {
  height: 70px;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

header nav li {
  display: inline-block;
  padding: 0 16px;
  text-align: center;
}

header nav a {
  color: #78B0C1;
}

header nav a:hover,
.router-link-active {
  color: #4FD4FF;
}

header nav a:hover i.iconfont,
.router-link-active i.iconfont {
  color: #fff;
}

header nav a i.iconfont {
  color: #8B9DB7;
  font-size: 44px;
}

.logo {
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.logo img {
  display: inline-block;
  height: 40px;
  margin-right: 10px;
}

.right-info {
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.right-info a {
  display: inline-block;
  height: 64px;
  width: 64px;
  border-radius: 32px;
  overflow: hidden;
  background-color: #fff;
  margin-right: 20px;
}

.right-info img {
  height: 64px;
}

.right-info span {
  color: #8B9DB7;
  font-size: 16px;
}

.right-info strong {
  font-size: 22px;
  font-weight: normal;
}

</style>
