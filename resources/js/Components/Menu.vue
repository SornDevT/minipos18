<template lang="">
   
<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  
<div class="app-brand demo ">
  <a href="index.html" class="app-brand-link">
    <span class="app-brand-logo demo" style="height: 80px;">



    </span>
    <span class="app-brand-text demo menu-text fw-bold ms-2">sneat</span>
  </a>

  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
    <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
  </a>
</div>

<div class="menu-inner-shadow"></div>



<ul class="menu-inner py-1">

  <!-- Dashboards -->
  <li class="menu-item">
    <router-link to="/store" class="menu-link">
        <i class='menu-icon bx bx-store'></i>
      <div class="text-truncate" data-i18n="Dashboards">ສະຕ໋ອກສິນຄ້າ</div>
    </router-link>
  </li>

  <li class="menu-item">
    <router-link to="/pos" class="menu-link">
      <i class='bx bx-cart menu-icon '></i>
      <div class="text-truncate" data-i18n="Dashboards">ຂາຍ POS</div>
    </router-link>
  </li>

  <li class="menu-item">
    <router-link to="/transection" class="menu-link">
      <i class='bx bx-transfer-alt menu-icon'></i>
      <div class="text-truncate" data-i18n="Dashboards">ການເຄື່ອນໄຫວ</div>
    </router-link>
  </li>

  <li class="menu-item">
    <router-link to="/report" class="menu-link">
      <i class='bx bx-bar-chart-alt-2 menu-icon'></i>
      <div class="text-truncate" data-i18n="Dashboards">ລາຍງານ</div>
    </router-link>
  </li>


 
</ul>

</aside>
<!-- / Menu -->

</template>
<script>
export default {
    
}
</script>
<style lang="">
    
</style>