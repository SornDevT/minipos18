<template lang="">
    <div>
        <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">

    {{ FormStore }}

    <div v-if="ShowForm">
        <div class=" d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2" @click="SaveStore()" :disabled="CheckForm" >ບັນທຶກ</button>
            <button type="button" class="btn btn-danger" @click="CancelStore()">ຍົກເລີກ</button>
        </div>
        <div class="row">
            <div class="col-md-4 text-center" style=" position: relative ">

                <button type="button" @click="remove_img()" class="btn rounded-pill btn-icon btn-danger bt_rm_img" v-if="FormStore.image">
                    <i class='bx bx-x fs-4'></i>
                </button>

                <img :src="Image_preview" @click="$refs.img_store.click()" class=" cursor-pointer rounded" style=" width:60%; " >

                <input type="file" style=" display:none;" @change="onSelect($event)" ref="img_store" >
            </div>
            <div class="col-md-8">
                <div>
            <label class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
            <input type="text" class="form-control mb-2" v-model="FormStore.name"  placeholder="...." >

            <label class="form-label fs-6">ຈຳນວນ:</label>
            <cleave :options="options" class="form-control" v-model="FormStore.qty"  placeholder="...." />
            <div class="row mt-2 mb-2">
                <div class="col-md-6">
                    <label>ລາຄາຊື້:</label>
                    <div class="input-group">
                    <cleave :options="options" class="form-control" v-model="FormStore.price_buy" placeholder="..." />
                    <span class="input-group-text" id="basic-addon11">ກີບ</span>
                    </div>

                </div>
                <div class="col-md-6">

                    <label>ລາຄາຂາຍ:</label>
                    <div class="input-group">
                    <cleave :options="options" class="form-control" v-model="FormStore.price_sell" placeholder="..." />
                    <span class="input-group-text" id="basic-addon11">ກີບ</span>
                    </div>

                </div>
            </div>

            </div>
            </div>
        </div>
    </div>


    <div v-else class="table-responsive text-nowrap">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class="me-2 cursor-pointer " @click="ChangeSort()"> 
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                </div>
                <!-- {{PerPage}} -->
                <select id="defaultSelect" v-model="PerPage" @change="GetStore()" class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
            </div>
            <div class=" d-flex">
                <div class="input-group ">
                    <input type="text" class="form-control" v-model="Search" @keyup.enter="GetStore()" placeholder="ຄົ້ນຫາ.." >
                    <button class="btn btn-primary" @click="GetStore()" type="button" ><i class='bx bx-search'></i></button>
                </div>
                <button type="button" @click="AddStore()" class="btn btn-info ms-2">ເພີ່ມໃໝ່</button>
            </div>
        </div>
        <!-- {{ StoreData }} -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th width="110">ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ຈຳນວນ</th>
            <th class="text-center">ລາຄາຊື້</th>
            <th class=" text-center">ຈັດການ</th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="item in StoreData.data" :key="item.id">
            <td>{{ item.id }}</td>
            <td class="text-center">
                
                <!-- {{ item.image }} -->
                <img :src="url + '/assets/img/' + item.image" v-if="item.image" class=" rounded " style="width:60px" >
                <img :src="url + '/assets/img/no-img.jpg'" v-else class=" rounded " style="width:60px" >
            </td>
            <td>{{ item.name }}</td>
            <td>{{ item.qty }}</td>
            <td class="text-end">{{ formatPrice(item.price_buy) }}</td>
            <td class="text-center">
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu" style="">
                  <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(item.id)"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="DelStore(item.id)" ><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>
          
        </tbody>
      </table>
      <Paginatiom :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />

      <button @click="showAlert">Hello world</button>
    </div>


  </div>
</div>
    </div>
</template>
<script>
import { useStore } from '../Store/auth';
import axios from 'axios';
export default {
    setup() {
        const store = useStore();
        return { store }
    },
    data() {
        return {
            Image_preview: window.location.origin+'/assets/img/upload-img.jpg',
            url: window.location.origin,
            EditID:'',
            Search:'',
            Sort:'desc',
            PerPage:5,
            ShowForm:false,
            FormType:true,
            FormStore:{
                name:'',
                image:'',
                qty:'',
                price_buy:'',
                price_sell:''
            },
            StoreData:[],
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: '.',
                  delimiter: ','
                }
        }
    },
    computed:{
        CheckForm(){
            if(this.FormStore.name == '' || this.FormStore.qty == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == ''){
                return true;
            } else {
                return false;
            }
        }
    },
    methods:{
        remove_img(){
            this.FormStore.image = '';
            this.Image_preview = window.location.origin+'/assets/img/upload-img.jpg';
        },
        onSelect(event){
            // console.log(event
            this.FormStore.image = event.target.files[0]
            let reader = new FileReader()
            reader.readAsDataURL(this.FormStore.image)
            reader.addEventListener("load", function(){
                this.Image_preview = reader.result
            }.bind(this,false));
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        showAlert() {
        // Use sweetalert2
        this.$swal({
            title: "ບັນທຶກຂໍ້ມູນ ສຳເລັດ",
            icon: "error",
            showConfirmButton:false,
            timer: 3500
            });
        },
        ChangeSort(){
            if(this.Sort == 'desc'){
                this.Sort = 'asc';
            } else {
                this.Sort = 'desc';
            }
            this.GetStore();
        },
        AddStore(){
            this.ShowForm = true;
            this.FormType = true;

            // clear form 
            this.FormStore.name = '';
            this.FormStore.image = '';
            this.FormStore.qty = '';
            this.FormStore.price_buy = '';
            this.FormStore.price_sell = '';
            this.Image_preview = window.location.origin+'/assets/img/upload-img.jpg';
        },
        CancelStore(){
            this.ShowForm = false;
        },
        EditStore(id){
            // console.log(id)

            this.FormType = false;
            this.EditID = id;

            axios.get(`api/store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+this.store.get_token }}).then((res) => {
                console.log(res.data);
                this.FormStore = res.data;
                this.ShowForm = true;

                if(res.data.image){
                    this.Image_preview= this.url + '/assets/img/' + res.data.image;
                } else {
                    this.Image_preview= this.url + '/assets/img/upload-img.jpg';
                }

                
            }).catch((error)=>{
                console.log(error);
            })


        },
        DelStore(id){

            this.$swal({
                    title: "ທ່ານແນ່ໃຈບໍ່?",
                    text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ຕົກລົງ!",
                    cancelButtonText: "ຍົກເລີກ"
                    }).then((result) => {
                    if (result.isConfirmed) {


                        axios.delete(`api/store/delete/${id}`,{ headers:{ Authorization: 'Bearer '+this.store.get_token }}).then((res)=>{
                            if(res.data.success){   
                                this.$swal({
                                    title: "ການລຶບຂໍ້ມູນ!",
                                    text: res.data.message,
                                    icon: "success",
                                    showConfirmButton:false,
                                    timer: 3500
                                });

                                this.GetStore();
                            } else {
                                this.$swal({
                                    title: res.data.message,
                                    icon: "error",
                                    showConfirmButton:false,
                                    timer: 3500
                                });
                            }
                        }).catch((error)=>{
                            console.log(error)
                        })
                        
                        
                        
                    }
            });


            


        },
        SaveStore(){
                // console.log('aaaaa')
                if(this.FormType){
                    // add new data
                   
                    axios.post('api/store/add',this.FormStore, { headers:{ "Content-Type":"multipart/form-data", Authorization: 'Bearer '+this.store.get_token }}).then((res)=>{

                        if(res.data.success){

                            // clear form 
                            this.FormStore.name = '';
                            this.FormStore.image = '';
                            this.FormStore.qty = '';
                            this.FormStore.price_buy = '';
                            this.FormStore.price_sell = '';

                            // show list data
                            this.ShowForm = false;

                            this.GetStore();

                            this.$swal({
                                position: 'top-end',
                                toast:true,
                                title: res.data.message,
                                icon: "success",
                                showConfirmButton:false,
                                timer: 2500
                            });

                            // console.log('Save Success!');
                        } else {

                            this.$swal({
                                title: res.data.message,
                                icon: "error",
                                showConfirmButton:false,
                                timer: 3500
                            });

                            // console.log(res.data.message)
                        }

                    }).catch((error)=>{
                        console.log(error)
                    })

                } else {
                    // console.log('update')
                    // update data
                    axios.post(`api/store/update/${this.EditID}`,this.FormStore, { headers:{ "Content-Type":"multipart/form-data", Authorization: 'Bearer '+this.store.get_token }}).then((res)=>{

                        if(res.data.success){

                            // clear form 
                            this.FormStore.name = '';
                            this.FormStore.image = '';
                            this.FormStore.qty = '';
                            this.FormStore.price_buy = '';
                            this.FormStore.price_sell = '';

                            // show list data
                            this.ShowForm = false;

                            this.GetStore();

                            this.$swal({
                                position: 'top-end',
                                toast:true,
                                title: res.data.message,
                                icon: "success",
                                showConfirmButton:false,
                                timer: 2500
                            });

                            // console.log('update Success!');
                        } else {

                            this.$swal({
                                title: res.data.message,
                                icon: "error",
                                showConfirmButton:false,
                                timer: 3500
                            });

                            // console.log(res.data.message)
                        }

                        }).catch((error)=>{
                        console.log(error)
                        })

                               
                }
        },
        GetStore(page){
            axios.get(`api/store?page=${page}&perpage=${this.PerPage}&sort=${this.Sort}&search=${this.Search}`, { headers:{ Authorization: 'Bearer '+this.store.get_token }}).then((res)=>{
                this.StoreData = res.data;
            }).catch((error)=>{
                console.log(error)
            })
        }
    },
    created(){
        this.GetStore();
    },
    watch:{
        Search(){
            if(this.Search == ''){
                this.GetStore();
            }
        }
    }
}
</script>
<style >

    .bt_rm_img {
        position: absolute;
        top: 0px;
        right: 10px;
    }
</style>