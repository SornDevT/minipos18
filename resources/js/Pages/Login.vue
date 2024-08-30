<template lang="">
    <div class=" d-flex justify-content-center">
        <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card px-sm-6 px-0">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">


            </span>
              <span class="app-brand-text demo text-heading fw-bold">MiniPos18</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1">ສະບາຍດີ! 👋</h4>
          <p class="mb-6">ກະລຸນາເຂົ້າສູ່ລະບົບ</p>

        
            <div class="mb-6">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" v-model="email" name="email-username" placeholder="..." autofocus="">
            </div>
            <div class="mb-6 form-password-toggle">
              <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" v-model="password" name="password" placeholder="···" >
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-8">
              <div class="d-flex justify-content-between mt-8">
                <div class="form-check mb-0 ms-2">
                  <input class="form-check-input" type="checkbox" v-model="remember_me" id="remember-me">
                  <label class="form-check-label" for="remember-me">
                    ຈຳຂ້ອຍໄວ້ໃນລະບົບ
                  </label>
                </div>
             
              </div>
            </div>
            <div class="mb-6"> 
              <button class="btn btn-primary d-grid w-100" :disabled="check_from_login" type="submit" @click="Login()">ເຂົ້າສູ່ລະບົບ</button>

            </div>
            <div class="alert alert-warning" role="alert" v-if="text_error || check_email_text || check_password_text">
                {{ text_error }} {{ check_email_text }} {{ check_password_text }}
            </div>
    

          <p class="text-center">
            <span>ບໍ່ມີຊື່ຜູ້ໃຊ້?</span>
            <router-link to="/register" >
              <span>ລົງທະບຽນ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
      return {
        email:'',
        password:'',
        text_error:'',
        check_email_text:'',
        check_password_text:'',
        show_pass:'',
        remember_me:false
      }
    },
    computed:{
      check_from_login(){
        // Email Regex
        const EmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // ກວດ email
        if(this.email){
          if(EmailRegex.test(this.email)){
            this.check_email_text = '';
          } else {
            this.check_email_text = 'ອີເມວລ໌ບໍ່ຖຶກຕ້ອງ';
          }

        } else {
          this.check_email_text = '';
        }

        // ກວດລະຫັດຜ່ານ ຕ້ອງຫຼາຍກວ່າ 3 ຕົວອັກສອນ
        if(this.password){
          if(this.password.length<=3){
            this.check_password_text = 'ລະຫັດຜ່ານຕ້ອງຫຼາຍກ່ວາ 4 ຕົວອັກສອນ';
          } else {
            this.check_password_text = '';
          }
        } else {
          this.check_password_text = '';
        }

        // ກວດຄວາມຖຶກຕ້ອງ ແລະປິດປຸ່ມ Login 1
        if(!EmailRegex.test(this.email) || this.password.length<=3){
          return true;
        } else {
          return false;
        }


        // ກວດຄວາມຖຶກຕ້ອງ ແລະປິດປຸ່ມ Login 2
        // if(this.email !='' && this.password !='' ){
        //   return false;
        // } else {
        //   return true;
        // }

      }
    },
    methods:{
      Login(){
          if( this.email != '' && this.password != '' ){
            axios.post('api/login',{
              login_email: this.email,
              login_password: this.password,
              login_remember_me: this.remember_me
            }).then((res)=>{
                if(res.data.success){
                  this.text_error = '';

                  // console.log(res.data)

                  // ເກັບ token ແລະ ຂໍ້ມູນຜູ້ໃຊ້ ໄວ້ໃນ localstorage
                  localStorage.setItem('web_token',res.data.token); // token
                  localStorage.setItem('web_user', JSON.stringify(res.data.user_data) )

                  // go to root path
                  this.$router.push('/');

                } else {
                  this.text_error = res.data.message;
                }
            })
          } 
      }
    }
}
</script>
<style lang="">
    
</style>