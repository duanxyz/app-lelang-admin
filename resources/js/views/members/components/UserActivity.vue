<template>
  <el-card v-if="user.name">
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Riwayat Transaksi" name="first">
        <el-table :data="history" style="width: 100%">
          <el-table-column
            label="Tanggal Permintaan"
            align="center"
          >
            <template slot-scope="scope">
              {{ scope.row.created_at | parseTime('{y}-{m}-{d} {h}:{i}') }}
            </template>
          </el-table-column>
          <el-table-column label="Nominal" align="center">
            <template slot-scope="scope">
              Rp. {{ formatPrice(scope.row.nominal) }}
            </template>
          </el-table-column>
          <el-table-column prop="keterangan" label="Keterangan" align="center" />
          <el-table-column label="Saldo Akhir" align="center">
            <template slot-scope="scope">
              Rp. {{ formatPrice(scope.row.ending_balance) }}
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
    history: {
      type: Array,
      default: () => {
        return {
          wallet_id: '',
          nominal: '',
          keterangn: '',
          ending_balance: '',
          created_at: '',
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
    formatPrice(value) {
      const val = (value / 1).toFixed(2).replace('.', ',');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
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
