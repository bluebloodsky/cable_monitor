<template>
  <div>
    <header>
      <div class="logo">
        <img src="../assets/img/logo.png">
        <h1>电缆通道综合在线监测系统</h1>
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
    <!--  <transition>
      <keep-alive> -->
    <router-view></router-view>
    <!--   </keep-alive>
    </transition> -->
  </div>
</template>
<script>
import { NAV_MENUS } from '@/shared/constant'
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
    this.nav_menus = NAV_MENUS
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
