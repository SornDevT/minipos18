<template lang="">
    <div>
        <div class="card">
  <h5 class="card-header">ການເຄື່ອນໄຫວ ທຸລະກຳ</h5>
  <div class="card-body">


    <div class="table-responsive text-nowrap">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class="me-2 cursor-pointer " @click="ChangeSort()"> 
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                </div>
                <!-- {{PerPage}} -->
                <select id="defaultSelect" v-model="PerPage" @change="GetTran()" class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
            </div>
            <div class=" d-flex">
                <div class="btn-group me-2" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" @click="month_type='m'"> <i class='bx bxs-chevron-right' v-if="month_type=='m'" ></i> ເດືອນ</button>
                <button type="button" class="btn btn-secondary" @click="month_type='y'" > <i class='bx bxs-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
              </div>

                <input type="date" class="form-control" v-model="dmy" >
           
            </div>
        </div>
        <!-- {{ StoreData }} -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ວັນທີ</th>
            <th >ເລກທີທຸລະກຳ</th>
            <th>ປະເພດທຸລະກຳ</th>
            <th>ລາຍລະອຽດ</th>
            <th class="text-center" >ມູນຄ່າ</th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="item in TransectionData.data" :key="item.id">
            <td>{{ date(item.created_at) }}</td>
            <td>{{ item.tran_id }}</td>
            <td>{{ item.tran_type }}</td>
            <td>{{ item.detail }}</td>
            <td class="text-end">{{ formatPrice(item.price) }}</td>
          </tr>
          
        </tbody>
      </table>
      <Paginatiom :pagination="TransectionData" :offset="4" @paginate="GetTran($event)" />

    </div>


  </div>
</div>
    </div>
</template>
<script>
import axios from 'axios';
import { useStore } from '../Store/auth';
import moment from 'moment'
export default {
    setup() {
        const store = useStore();
        return { store }
    },
    data() {
        return {
            month_type:'m',
            dmy: new Date().toISOString().slice(0,10),
            Sort:'desc',
            PerPage:5,
            TransectionData:[],
        }
    },
    components:{
        moment
    },
    methods:{
        ChangeSort(){
            if(this.Sort == 'desc'){
                this.Sort = 'asc';
            } else {
                this.Sort = 'desc';
            }
            this.GetTran();
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        date(value){
            return moment(value).format('DD/MM/YYYY');
        },
        GetTran(page){
            axios.post(`api/transection?page=${page}&perpage=${this.PerPage}&sort=${this.Sort}`,{
                month_type: this.month_type,
                dmy: this.dmy
            },{ headers:{ Authorization: 'Bearer '+this.store.get_token }}).then((res)=>{
                this.TransectionData = res.data;
            }).catch((error)=>{
                console.log(error)
            })
        }   
    },
    created(){
        this.GetTran()
    },
    watch:{
        dmy(){
            this.GetTran()
        },
        month_type(){
            this.GetTran()
        }
    }
}
</script>
<style lang="">
    
</style>