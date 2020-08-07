<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="listQuery.keyword"
        :placeholder="$t('table.name')"
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
      <el-badge v-if="!listLoading" :value="setorTotal" class="filter-item">
        <el-checkbox v-model="checked1" label="Setor" border />
      </el-badge>
    </div>

    <el-table
      v-if="!checked1"
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <el-table-column align="center" label="No" width="50px" type="index" />
      <el-table-column label="Nama" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Alamat" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.address }}</span>
        </template>
      </el-table-column>
      <el-table-column label="No Telpon" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.phone_number }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Saldo" align="center">
        <template slot-scope="scope">
          <router-link :to="'/members/member/view/'+5853" class="link-type">
            <span>Rp.{{ formatPrice(scope.row.saldo) }}</span>
          </router-link>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <router-link :to="'/members/member/view/'+scope.row.id">
            <el-button type="primary" size="small" icon="money">Detail</el-button>
          </router-link>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-if="!checked1"
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />
    <el-table
      v-if="checked1"
      v-loading="listLoading"
      :data="deposit"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <el-table-column align="center" label="No" type="index" width="50px" />
      <el-table-column label="Nama" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.user.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Alamat" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.user.address }}</span>
        </template>
      </el-table-column>
      <el-table-column label="No Telpon" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.user.phone_number }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Saldo" align="center">
        <template slot-scope="scope">
          <router-link :to="'/members/member/view/'+scope.row.deposit.wallet_id">
            <span>Rp.{{ formatPrice(scope.row.saldo) }}</span>
          </router-link>
        </template>
      </el-table-column>
      <el-table-column v-if="checked1" label="Bukti" align="center">
        <template slot-scope="scope">
          <el-image
            :src="'/images/proof/'+scope.row.deposit.proof"
            style="width:40px"
          />
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <el-button
            size="small"
            type="success"
            @click="updateData(scope.row.deposit.wallet_id, scope.row.deposit)"
          >Proses</el-button>
          <router-link :to="'/members/member/view/'+scope.row.deposit.wallet_id">
            <el-button type="primary" size="small" icon="money">Detail</el-button>
          </router-link>
        </template>
      </el-table-column>
    </el-table>
    <pagination
      v-if="checked1"
      v-show="setorTotal>0"
      :total="setorTotal"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getDeposit"
    />
  </div>
</template>

<script>
import Resource from '@/api/resource';
const memberResource = new Resource('members');
const depositResource = new Resource('deposits');
const walletResource = new Resource('wallets');

import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

export default {
  // name: 'MemberTable',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        NotVerified: 'danger',
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      list: null,
      deposit: null,
      total: 0,
      setorTotal: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 15,
        keyword: '',
      },
      statusOptions: ['published', 'draft', 'Not Verified'],
      downloadLoading: false,
      checked1: false,
    };
  },
  created() {
    this.getList();
    this.getDeposit();
  },
  methods: {
    async getDeposit() {
      const { limit, page } = this.listQuery;
      const { data, meta } = await depositResource.list(this.listQuery);
      this.deposit = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.setorTotal = meta.total;
    },
    async getList() {
      const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { data, meta } = await memberResource.list(this.listQuery);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.listLoading = false;
    },
    updateData(id, row) {
      walletResource
        .update(id, row)
        .then(response => {
          this.$message({
            type: 'success',
            message: 'Deposit info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getDeposit();
        })
        .catch(error => {
          console.log(error);
        });
    },
    handleFilter() {
      this.listQuery.page = 1;
      if (!this.checked1){
        this.getList();
      } else {
        this.getDeposit();
      }
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
<style>
.item {
  margin-top: 10px;
  margin-right: 40px;
}
</style>
