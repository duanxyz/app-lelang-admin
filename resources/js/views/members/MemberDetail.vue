<template>
  <div class="app-container">
    <el-form v-if="user" :model="user">
      <el-row :gutter="20">
        <el-col :span="6">
          <user-card :user="user" :wallet="wallet" />
          <!-- <user-bio /> -->
        </el-col>
        <el-col :span="18">
          <user-activity :user="user" :history="history" />
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
const historyResource = new Resource('history');
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
      history: null,
      query: {
        id: null,
      },
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
    this.getHistory(id);
  },
  methods: {
    async getUser(id) {
      const { data } = await userResource.get(id);
      this.user = data;
    },
    async getHistory(id) {
      const { data } = await historyResource.list(this.query);
      this.history = data;
    },
    async getWallet(id) {
      // const { data } = await userResource.get(id);
      const { data } = await walletResource.get(id);
      this.wallet = data;
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
