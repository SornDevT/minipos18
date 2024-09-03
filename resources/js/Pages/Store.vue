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
            <div class="col-md-4">Image</div>
            <div class="col-md-8">
                <div>
            <label class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
            <input type="text" class="form-control mb-2" v-model="FormStore.name"  placeholder="...." >

            <label class="form-label fs-6">ຈຳນວນ:</label>
            <input type="text" class="form-control" v-model="FormStore.qty"  placeholder="...." >
            <div class="row mt-2 mb-2">
                <div class="col-md-6">
                    <label>ລາຄາຊື້:</label>
                    <div class="input-group">
                    <input type="text" class="form-control" v-model="FormStore.price_buy" placeholder="..." >
                    <span class="input-group-text" id="basic-addon11">ກີບ</span>
                    </div>

                </div>
                <div class="col-md-6">

                    <label>ລາຄາຂາຍ:</label>
                    <div class="input-group">
                    <input type="text" class="form-control" v-model="FormStore.price_sell" placeholder="..." >
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
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ຈຳນວນ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="item in StoreData.data" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.image }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.qty }}</td>
            <td>{{ item.price_buy }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu" style="">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                </div>
              </div>
            </td>
          </tr>
          
        </tbody>
      </table>
      <Paginatiom :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />
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
        },
        CancelStore(){
            this.ShowForm = false;
        },
        SaveStore(){

                if(this.FormType){
                    // add new data

                    axios.post('api/store/add',this.FormStore, { headers:{ Authorization: 'Bearer '+this.store.get_token }}).then((res)=>{

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

                            console.log('Save Success!');
                        } else {
                            console.log(res.data.message)
                        }

                    }).catch((error)=>{
                        console.log(error)
                    })

                } else {
                    // update data


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
<style lang="">
    
</style>