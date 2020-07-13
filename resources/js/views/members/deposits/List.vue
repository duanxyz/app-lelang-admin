<template>
  <div class="app-container">
    <el-table
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <el-table-column align="center" label="ID" width="70">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Nama Pengirim" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.sender }}</span>
        </template>
      </el-table-column>
      <el-table-column label="No Rekening" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.account_number }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Jumlah Deposit" align="center">
        <template slot-scope="scope">
          <span>Rp.{{ formatPrice(scope.row.deposit_amount) }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Bukti" align="center">
        <template slot-scope="scope">
          <el-image
            :src="'/images/proof/'+scope.row.proof"
            @click="setSrcList('/images/proof/'+scope.row.proof)"
          />
        </template>
      </el-table-column>
      <el-table-column label="Tanggal Deposit" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.sent_date | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions" width="190" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button
            size="small"
            type="success"
            @click="updateData(scope.row.wallet_id, scope.row)"
          >Terima</el-button>
          <router-link :to="'/members/member/view/'+scope.row.wallet_id">
            <el-button type="primary" size="small" icon="money">Detail User</el-button>
          </router-link>
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
    <el-dialog :visible.sync="imageVisible">
      <el-image :src="img" />
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
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
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 15,
      },
      statusOptions: ['published', 'draft', 'Not Verified'],
      downloadLoading: false,
      img: '',
      imageVisible: false,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { data, meta } = await depositResource.list(this.listQuery);
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
          this.getList();
        })
        .catch(error => {
          console.log(error);
        });
    },
    setSrcList(photo) {
      this.img = photo;
      this.imageVisible = true;
    },
    formatPrice(value) {
      const val = (value / 1).toFixed(2).replace('.', ',');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
  },
};
</script>
