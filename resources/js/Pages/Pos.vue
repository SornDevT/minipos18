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
                            <span class="box-num">
                                10
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
                        <input type="text" class="form-control mb-1" placeholder="...." >
                        <label>ເບີໂທ:</label>
                        <input type="text" class="form-control mb-1" placeholder="...." >
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
                                        <div class="text-end">1 x 100.000</div>
                                        <div class=" d-flex justify-content-between">
                                            <span>01</span>
                                            <span>02</span>
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
                    <span>100,000 ກີບ</span>
                </div>
                <div class="p-2">

                    <button type="button" class="btn rounded-pill btn-success w-100 ">ຊຳລະເງິນ</button>

                </div>
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
            url:window.location.origin,
            StoreData:[],
            ListOrder:[],
            Search:'',
            Sort:'desc',
            PerPage:100,
        }
    },
    methods:{
        AddProduct(id){
            // console.log(id)

            let item = this.StoreData.data.find((i)=>i.id == id);
            // console.log(item)

            this.ListOrder.push({
                id: item.id,
                name: item.name,
                image:item.image,
                price: item.price_sell,
                qty: 1
            });
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