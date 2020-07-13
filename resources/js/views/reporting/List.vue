<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="listQuery.keyword"
        placeholder="Nama barang"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >{{ $t('table.search') }}</el-button>
    </div>
    <div class="label-container">
      <span>Data Laporan Lelang Online Pada Pegadaian Sumenep</span>
    </div>

    <el-table
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <!-- <el-table-column align="center" label="ID" width="60">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column> -->
      <el-table-column label="barang" width="220px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.data }}</span>
        </template>
      </el-table-column>
      <!-- <el-table-column label="Harga Awal" width="140px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.initial_price }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Harga Akhir" width="140px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.final_price }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Pemenang Lelang" width="220px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.auction_winner }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Tanggal Lelang" width="150px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at | parseTime('{y}-{m}-{d}') }}</span>
        </template>
      </el-table-column> -->
    </el-table>

    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />
  </div>
</template>

<script>
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
const reportingResource = new Resource('reporting');

export default {
  // name: 'MemberTable',
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      itemCreating: false,
      listQuery: {
        page: 1,
        limit: 15,
        keyword: '',
        item_id: null,
      },
      listQueryAuction: {
        page: 1,
        item_id: '',
      },
      loadingHistory: true,
      totalHistory: 0,
      history: null,
      dialogStatus: '',
      dialogFormVisible: false,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      // const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { bulan } = await reportingResource.list({});
      // list(this.listQuery);
      this.list = bulan;
      // this.list.forEach((element, index) => {
      //   element['index'] = (page - 1) * limit + index + 1;
      // });
      // this.total = meta.total;
      this.listLoading = false;
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    // indexMethod(index) {
    //   return index + 1;
    // },
  },
};
</script>
