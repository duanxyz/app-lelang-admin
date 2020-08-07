<template>
  <el-card v-if="user.name">
    <div class="user-profile">
      <div class="user-avatar box-center">
        <pan-thumb :image="user.avatar" :height="'100px'" :width="'100px'" :hoverable="false" />
      </div>
      <div class="box-center">
        <div class="user-name text-center">{{ user.name }}</div>
        <!-- <div class="user-role text-center text-muted">
          {{ getRole() }}
        </div>-->
        <div class="user-bio">
          <div slot="header" class="clearfix">
            <span>Details User</span>
          </div>
          <div class="user-bio-section">
            <div class="user-bio-section-header">
              <span>Email</span>
            </div>
            <div class="user-bio-section-body">
              <div class="text-muted">{{ user.email }}</div>
            </div>
          </div>
          <div class="user-bio-section">
            <div class="user-bio-section-header">
              <span>No.Telp</span>
            </div>
            <div class="text-muted">{{ user.phone_number }}</div>
          </div>
          <div class="user-bio-section">
            <div class="user-bio-section-header">
              <span>Saldo</span>
            </div>
            <div class="text-muted">Rp. {{ formatPrice(wallet.balance) }}</div>
          </div>
          <div class="user-bio-section">
            <div class="user-bio-section-header">
              <span>Status</span>
            </div>
            <div class="text-muted">
              <el-tag>{{ user.status }} </el-tag>
            </div>
          </div>
        </div>
      </div>
    </div>
  </el-card>
</template>

<script>
import PanThumb from '@/components/PanThumb';

export default {
  components: { PanThumb },
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          phone_number: '',
          avatar: '',
        };
      },
    },
    wallet: {
      type: Object,
      default: () => {
        return {
          balance: '',
        };
      },
    },
  },
  data() {
    return {};
  },
  methods: {
    formatPrice(value) {
      const val = (value / 1).toFixed(2).replace('.', ',');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
  },
};
</script>

<style lang="scss" scoped>
.user-profile {
  .user-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .user-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }
  .box-social {
    padding-top: 30px;
    .el-table {
      border-top: 1px solid #dfe6ec;
    }
  }
  .user-follow {
    padding-top: 20px;
  }
}
.user-bio {
  margin-top: 20px;
  color: #606266;
  span {
    padding-left: 4px;
  }
  .user-bio-section {
    font-size: 14px;
    padding: 7px 0;
    .user-bio-section-header {
      border-bottom: 1px solid #dfe6ec;
      padding-bottom: 10px;
      margin-bottom: 10px;
      font-weight: bold;
    }
  }
}
</style>
