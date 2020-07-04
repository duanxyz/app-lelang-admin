<template>
  <div class="app-container">
    <el-form v-if="user" :model="user">
      <el-row :gutter="20">
        <el-col :span="6">
          <user-card :user="user" :wallet="wallet" :deposit="deposit" />
          <!-- <user-bio /> -->
        </el-col>
        <el-col :span="18">
          <user-activity :user="user" :wallet="wallet" :deposit="deposit" :withdraw="withdraw" :spending="spending" :method="updateData" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import Resource from '@/api/resource';
// import UserBio from './components/UserBio';
import UserCard from './components/UserCard';
import UserActivity from './components/UserActivity';

const userResource = new Resource('members');
const walletResource = new Resource('wallets');
export default {
  name: 'EditUser',
  components: {
    // UserBio,
    UserCard,
    UserActivity },
  data() {
    return {
      user: {},
      wallet: {},
      deposit: [],
      withdraw: [],
      spending: [],
    };
  },
  watch: {
    '$route': 'getUser',
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    const currentUserId = this.$store.getters.userId;
    if (id === currentUserId) {
      this.$router.push('/profile/edit');
      return;
    }
    this.getUser(id);
    this.getWallet(id);
  },
  methods: {
    async getUser(id) {
      const { data } = await userResource.get(id);
      this.user = data;
    },
    async getWallet(id) {
      // const { data } = await userResource.get(id);
      const { data, deposit, withdraw, spending } = await walletResource.get(id);
      // this.user = data;
      this.wallet = data;
      this.deposit = deposit;
      this.withdraw = withdraw;
      this.spending = spending;
    },
    updateData(id, row, msg) {
      walletResource
        .update(id, row)
        .then(response => {
          this.$message({
            type: 'success',
            message: msg + ' info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getUser(id);
          this.getWallet(id);
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>
