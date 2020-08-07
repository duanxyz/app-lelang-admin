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
      <el-select
        v-model="listQuery.category"
        placeholder="kategori"
        clearable
        style="width: 90px"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option v-for="item in items" :key="item" :label="item | uppercaseFirst" :value="item" />
      </el-select>
      <el-date-picker
        v-model="listQuery.year"
        type="year"
        class="filter-item"
        value-format="yyyy"
        placeholder="Pilih tahun"
      />
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >{{ $t('table.search') }}</el-button>
    </div>

    <el-table
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <el-table-column align="center" label="No" width="60">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Nama Barang" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.item_name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Harga Awal" align="center">
        <template slot-scope="scope">
          <span>Rp. {{ formatPrice(scope.row.initial_price) }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Harga Akhir" align="center">
        <template slot-scope="scope">
          <span>Rp. {{ formatPrice(scope.row.final_price) }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Kategori" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.category }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Pemenang Lelang" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.auction_winner }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Tanggal Lelang" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at | parseTime('{y}-{m}-{d}') }}</span>
        </template>
      </el-table-column>
      <el-table-column fixed="right" align="center" label="Actions" width="185">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="mini"
            @click="handleHistory(scope.row.item_id);"
          >Histori Tawaran</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />

    <el-dialog title="Histori Lelang" :visible.sync="dialogFormVisible">
      <div class="form-container">
        <el-table
          v-loading="loadingHistory"
          :data="history"
          label-position="left"
          label-width="150px"
          style="width: 100%;"
          border
          fit
          highlight-current-row
        >
          <el-table-column align="center" label="Username penawar">
            <template slot-scope="scope">
              <span>{{ scope.row.bidder_username }}</span>
            </template>
          </el-table-column>
          <el-table-column align="center" label="Jumlah tawaran">
            <template slot-scope="scope">
              <span>Rp. {{ formatPrice(scope.row.offer) }}</span>
            </template>
          </el-table-column>
        </el-table>
        <pagination
          v-show="totalHistory>0"
          :total="totalHistory"
          :page.sync="listQueryAuction.page"
          @pagination="getHistory"
        />
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
const resultResource = new Resource('results');
const historyResource = new Resource('auctions');

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
        category: '',
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
      items: ['perhiasan', 'kendaraan', 'sertifikat', 'elektronik'],
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { data, meta } = await resultResource.list(this.listQuery);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.listLoading = false;
    },
    async getHistory() {
      const { limit, page } = this.listQueryAuction;
      this.loadingHistory = true;
      const { data, meta } = await historyResource.list(this.listQuery);
      this.history = data;
      this.history.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.totalHistory = meta.total;
      this.loadingHistory = false;
    },
    handleHistory(id) {
      this.listQuery.item_id = id;
      this.dialogFormVisible = true;
      this.getHistory();
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    formatPrice(value) {
      const val = (value / 1).toFixed(2).replace('.', ',');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    // indexMethod(index) {
    //   return index + 1;
    // },
  },
};
</script>
