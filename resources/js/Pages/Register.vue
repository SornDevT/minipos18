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
           <!-- {{ user_name }} -->
          <h4 class="mb-1 mt-4">ລົງທະບຽນ ຜູ້ໃຊ້ໃໝ່</h4>
          <div class="mb-6">
              <label for="user_name" class="form-label fs-6">ຊື່ຜູ້ໃຊ້:</label>
              <input type="text" class="form-control" id="user_name" v-model="user_name" name="username" placeholder="..." >
            </div>
            <div class="mb-6">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" v-model="user_email" name="email-username" placeholder="..." >
            </div>
            <div class="mb-6 form-password-toggle">
              <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" v-model="password" name="password" placeholder="···" >
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-6 form-password-toggle">
              <label class="form-label fs-6" for="password2">ຍືນຍັນລະຫັດຜ່ານ:</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password2" class="form-control" v-model="password2" name="password2" placeholder="···" >
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="alert alert-warning" role="alert" v-if="text_error">
                {{ text_error }}
            </div>
            <div class="mb-6">
              <button class="btn btn-primary d-grid w-100" type="submit" @click="Register()">ລົງທະບຽນ</button>
            </div>
    

          <p class="text-center">
            <span>ມີຊື່ຜູ້ໃຊ້ແລ້ວ!</span>
            <router-link to="/login" >
              <span>ເຂົ້າສູ່ລະບົບ</span>
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
            user_name:'',
            user_email:'',
            password:'',
            password2:'',
            text_error:''
        }
    },
    methods:{
        Register(){
            // console.log('test function')
            if(this.user_name == '' || this.user_email == '' || this.password == ''){
                this.text_error = 'ກະລຸນາປ້ອນຂໍ້ມູນ ໃຫ້ຄົບຖ້ວນ!';
            } else {
                if(this.password == this.password2){
                    this.text_error = '';

                    // send http request
                    axios.post('api/register',{
                        form_user_name: this.user_name,
                        form_user_email: this.user_email,
                        form_password: this.password
                    }).then((res)=>{
                        console.log(res);
                    }).catch((err)=>{
                        console.log(err)
                    })


                } else {
                    this.text_error = 'ລະຫັດຜ່ານບໍ່ກົງກັນ!';
                }

            }
        }
    }
}
</script>
<style lang="">
    
</style>