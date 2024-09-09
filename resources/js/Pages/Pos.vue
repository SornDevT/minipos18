<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <input type="text" class="form-control" v-model="Search" placeholder="ຄົ້ນຫາ...">
                </div>
            </div>
            <PerfectScrollbar>
            <div style="height:60vh">
                <div class="row">
                    <div class="col-md-3 mb-3" v-for="item in StoreData.data" :key="item.id">
                        <div class="card h-100 cursor-pointer" style=" position:relative " @click="AddProduct(item.id)">
                            <span v-for="i in ListOrder" :key="i.id">
                                    <span class="box-num" v-if="item.id == i.id">
                                        {{ i.qty }}
                                    </span>
                            </span>
                            <img :src="url + '/assets/img/' + item.image" v-if="item.image" class="card-img-top img-pos " >
                            <img :src="url + '/assets/img/no-img.jpg'" v-else class="card-img-top img-pos "  >
                            <div class="card-body p-1 text-center">
                                <h5 class="mb-1">{{ item.name }}</h5>
                                <p class="card-text">
                                {{ item.price_sell }} Kip
                                </p>
                                
                            </div>
                            </div>
                    </div>
                </div>

            </div>
        </PerfectScrollbar>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-0">
                   <div class="p-3">
                        <label>ຊື່ລູກຄ້າ:</label>
                        <input type="text" class="form-control mb-1" v-model="customer_name" placeholder="...." >
                        <label>ເບີໂທ:</label>
                        <input type="text" class="form-control mb-1" v-model="customer_tel" placeholder="...." >
                   </div>
                   <div class=" p-2 bg-info text-white ">
                    ລາຍການສັ່ງຊື້
                   </div>
                <PerfectScrollbar>
                   <div style="height:35vh">  
                    <table class="table">
                        <tbody v-if="ListOrder.length>0">
                            <tr v-for="item in ListOrder" :key="item.id">
                                <td class="p-1 d-flex" >
                                    <img :src="url + '/assets/img/' + item.image" v-if="item.image" class=" list-pos-img " >
                                    <img :src="url + '/assets/img/no-img.jpg'" v-else class=" list-pos-img "  >
                                    <div class="ms-1 w-100 pe-2">
                                        <span> {{ item.name }} </span>
                                        <div class="text-end">{{ item.qty }} x {{ formatPrice(item.price)}}</div>
                                        <div class=" d-flex justify-content-between">
                                            <span> 
                                                
                                                <i class='bx bxs-plus-circle cursor-pointer text-success' @click="AddProduct(item.id)"></i> | <i class='bx bxs-no-entry cursor-pointer text-warning' @click="RemoveProduct(item.id)"></i> | <i class='bx bxs-trash cursor-pointer text-danger' @click="DelProduct(item.id)"></i>
                                            </span>
                                            <span>
                                                {{ formatPrice(item.qty*item.price) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td>
                                    <div class=" text-muted justify-content-center fs-4 align-items-center d-flex" style=" height:260px; ">
                                        ບໍ່ມີລາຍການ
                                    </div>
                                   
                                </td>
                            </tr>
                        </tbody>

                        </table>
                   </div>
                </PerfectScrollbar>
                <div class=" p-2 d-flex justify-content-between bg-info text-white">
                    <span>ລວມຍອດເງິນ:</span>
                    <span>{{ formatPrice(SumTotal) }} ກີບ</span>
                </div>
                <div class="p-2">

                    <button type="button" :disabled="!SumTotal" class="btn rounded-pill btn-success w-100 " @click="Pay()" >ຊຳລະເງິນ</button>

                </div>
                </div>
            </div>
        </div>
       
    </div>

    <div class="modal fade" id="dialog_pay" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">ການຊຳລະເງິນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class=" d-flex justify-content-between">
                                <span>ລວມຍອດເງິນ:</span>
                                <span>{{ formatPrice(SumTotal) }} ກີບ</span>
                            </div>
                            <div class=" d-flex justify-content-between text-danger" v-if="(CashAmount-SumTotal)>0">
                                <span>ເງິນທອນ:</span>
                                <span>{{ formatPrice(CashAmount-SumTotal) }} ກີບ</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <label>ຮັບເງິນນຳລູກຄ້າ</label>
                            <cleave :options="options" v-model="CashAmount" class=" form-control text-end" />
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100" @click="AddNum(500)" >500</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(1000)">1.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(2000)" >2.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(5000)">5.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(10000)">10.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(20000)" >20.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(50000)">50.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(100000)" >100.000</button>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
                <div class="modal-footer">
                  
                  <button type="button" class="btn btn-primary me-2" :disabled="CheckBTPay" @click="ComfirmPay()" >ບັນທຶກ</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
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
            customer_name:'',
            customer_tel:'',
            CashAmount:'',
            url:window.location.origin,
            StoreData:[],
            ListOrder:[],
            Search:'',
            Sort:'desc',
            PerPage:100,
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
        CheckBTPay(){
            if(this.CashAmount>=this.SumTotal){
                return false;
            } else {
                return true;
            }
        },
        SumTotal(){
            let value = this.ListOrder.reduce((num, item)=> parseInt(num) + ( parseInt(item.qty) * parseInt(item.price) ),0)
            return value;
        }
    },
    methods:{
        ComfirmPay(){

            axios.post('api/transection/add',{
                customer_name: this.customer_name,
                customer_tel: this.customer_tel,
                listorder: this.ListOrder
            }, { headers:{ Authorization: 'Bearer '+this.store.get_token }}).then((res)=>{

                if(res.data.success){

                    this.customer_name = '';
                    this.customer_tel = '';
                    this.ListOrder = [];
                    this.CashAmount = 0;

                    this.GetStore();

                    $('#dialog_pay').modal('hide');

                    this.$swal({
                                position: 'top-end',
                                toast:true,
                                title: res.data.message,
                                icon: "success",
                                showConfirmButton:false,
                                timer: 2500
                            });

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

        },
        AddNum(num){
            // 1 + 2 = 3
            this.CashAmount = parseInt(this.CashAmount?this.CashAmount:0) + parseInt(num);
        },
        Pay(){

            $('#dialog_pay').modal('show');
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        RemoveProduct(id){
            let item = this.ListOrder.find((i)=>i.id == id);
            // console.log(item)
            if(item){
                item.qty--;
                if(item.qty<1){
                    this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1);
                }
            }
        },
        DelProduct(id){

            this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1);
        },
        AddProduct(id){
            // console.log(id)

            let item = this.StoreData.data.find((i)=>i.id == id);
            let old_item = this.ListOrder.find((i)=>i.id == id);
            // console.log(item)

            if(old_item){

                    old_item.qty++;

            } else {

                this.ListOrder.push({
                    id: item.id,
                    name: item.name,
                    image:item.image,
                    price: item.price_sell,
                    qty: 1
                });
            }

            
        },
        RemoveItem(id){

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
    }
}
</script>
<style >
.list-pos-img {
    width: 60px;
    height: 60px;
    object-position: center;
    object-fit: cover;
    border: 1px solid #c9c9ca;
    padding: 2px;
    border-radius: 5px;
}
.box-num{
    position: absolute;
    background-color: blueviolet;
    color: white;
    padding: 5px;
    right: 0px;
    border-radius: 0px 5px 0px 5px;
}
    .img-pos{
        height: 110px;
        width: 100%;
        object-position: center;
        object-fit: cover;
    }
</style>