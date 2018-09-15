<template>
   <div>

      <header class="main-header">
         <!-- Logo -->
         <span href="../../index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>W</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Warehouse</b></span>
         </span>
         <!-- Header Navbar: style can be found in header.less -->
         <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <span href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </span>
         </nav>
      </header>

      <aside class="main-sidebar">
         <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
               <li>
                  <router-link to="/"><i class="fa fa-circle-o text-aqua"></i> <span>Головна</span></router-link>
               </li>
               <li>
                  <router-link to="/warehouse"><i class="fa fa-circle-o text-aqua"></i> <span>Склади</span></router-link>
               </li>
               <li>
                  <router-link to="/warehouse/materials"><i class="fa fa-circle-o text-aqua"></i> <span>Матеріали</span></router-link>
               </li>
               <li>
                  <router-link to="/transportation/carriers"><i class="fa fa-circle-o text-aqua"></i> <span>Перевізники</span></router-link>
               </li>
               <li>
                  <router-link to="/transportation"><i class="fa fa-circle-o text-aqua"></i> <span>Перевезення</span></router-link>
               </li>
               <li>
                  <router-link to="/warehouses-map"><i class="fa fa-circle-o text-aqua"></i> <span>Карта складів</span></router-link>
               </li>
               <li>
                  <router-link to="/consumption"><i class="fa fa-circle-o text-aqua"></i> <span>Транспортні витрати</span></router-link>
               </li>
               <li>
                  <router-link to="/user"><i class="fa fa-circle-o text-aqua"></i> <span>Користувачі</span></router-link>
               </li>
               <li>
                  <a href="/logout"><i class="fa fa-circle-o text-aqua"></i> <span>Вихід</span></a>
               </li>
            </ul>
         </section>
      </aside>

      <div class="content-wrapper">
         <router-view></router-view>
      </div>

      <footer class="main-footer">
         <strong>Warehouse</strong>
      </footer>
   </div>
</template>