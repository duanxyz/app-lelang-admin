<template>
  <el-card v-if="user.name">
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Riwayat Transaksi" name="first">
        <div class="user-activity">Riwayat Transaksi</div>
      </el-tab-pane>
      <el-tab-pane label="Info Deposit" name="second">
        <el-table :data="deposit" style="width: 100%">
          <el-table-column fixed prop="sent_date" label="Tanggal Kirim" width="120" align="center" />
          <el-table-column prop="sender" label="Nama Pengirim" width="150" align="center" />
          <el-table-column prop="account_number" label="No. Rekening" width="160" align="center" />
          <el-table-column prop="deposit_amount" label="Jumlah" width="130" align="center" />
          <el-table-column label="Bukti" width="120" align="center">
            <template slot-scope="scope">
              <el-image
                :src="scope.row.proof"
                style="width: 50px; height: 50px;"
                :preview-src-list="srcList"
              />
            </template>
          </el-table-column>
          <el-table-column prop="status" label="Status" width="120" />
          <el-table-column fixed="right" label="Operations" width="120">
            <template slot-scope="scope">
              <el-button
                size="mini"
                type="success"
                @click="updateData(scope.row.wallet_id, scope.row, 'Deposit')"
              >Terima</el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-tab-pane>
      <el-tab-pane label="Info Withdraw" name="third">
        <el-table :data="withdraw" style="width: 100%">
          <el-table-column
            fixed
            prop="created_at"
            label="Tanggal Permintaan"
            width="120"
            align="center"
          />
          <el-table-column prop label="Nama Bank" width="150" align="center" />
          <el-table-column prop="receiver" label="Nama Penerima" width="150" align="center" />
          <el-table-column prop="account_number" label="No. Rekening" width="160" align="center" />
          <el-table-column prop="withdraw_amount" label="Jumlah" width="130" align="center" />
          <el-table-column prop="status" label="Status" width="120" />
          <el-table-column fixed="right" label="Operations" width="120">
            <template slot-scope="scope">
              <el-button
                size="mini"
                type="success"
                @click="updateData(scope.row.wallet_id, scope.row, 'Withdraw')"
              >Terima</el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
export default {
  props: {
    // eslint-disable-next-line vue/require-default-prop
    method: { type: Function },
    deposit: {
      type: Array,
      default: () => {
        return {
          wallet_id: '',
          sender: '',
          account_number: '',
          deposit_amount: '',
          proof: '',
          sent_date: '',
          status: '',
        };
      },
    },
    withdraw: {
      type: Array,
      default: () => {
        return {
          wallet_id: '',
        };
      },
    },
    spending: {
      type: Array,
      default: () => {
        return {
          wallet_id: '',
        };
      },
    },
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          balance: '',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      srcList: ['https://i.pravatar.cc'],
      activeActivity: 'first',
      carouselImages: [
        'https://cdn.laravue.dev/photo1.png',
        'https://cdn.laravue.dev/photo2.png',
        'https://cdn.laravue.dev/photo3.jpg',
        'https://cdn.laravue.dev/photo4.jpg',
      ],
      updating: false,
    };
  },
  methods: {
    updateData(id, row, msg) {
      this.method(id, row, msg);
    },
    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
  },
};
</script>

<style lang="scss" scoped>
.user-activity {
  .user-block {
    .username,
    .description {
      display: block;
      margin-left: 50px;
      padding: 2px 0;
    }
    img {
      width: 40px;
      height: 40px;
      float: left;
    }
    :after {
      clear: both;
    }
    .img-circle {
      border-radius: 50%;
      border: 2px solid #d2d6de;
      padding: 2px;
    }
    span {
      font-weight: 500;
      font-size: 12px;
    }
  }
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;
    .image {
      width: 100%;
    }
    .user-images {
      padding-top: 20px;
    }
  }
  .list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
    li {
      display: inline-block;
      padding-right: 5px;
      padding-left: 5px;
      font-size: 13px;
    }
    .link-black {
      &:hover,
      &:focus {
        color: #999;
      }
    }
  }
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n + 1) {
    background-color: #d3dce6;
  }
}
</style>
