<template>
  <div class="dashboard-editor-container">
    <panel-group v-if="status" :user="reportData" @handleSetLineChartData="handleSetLineChartData" />

    <el-row :gutter="32">
      <el-col :xs="24" :sm="24" :lg="100">
        <div class="chart-wrapper">
          <pie-chart v-if="status" :category.sync="reportCategory" />
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="16" hidden>
        <div class="chart-wrapper">
          <line-chart v-if="status" :chart-data="lineChartData" />
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import PanelGroup from './components/PanelGroup';
import LineChart from './components/LineChart';
import PieChart from './components/PieChart';
import Resource from '@/api/resource';
const reportingResource = new Resource('reporting');

// const lineChartData = {
//   newVisitis: {
//     expectedData: [100, 120, 161, 134, 105, 160, 165, 0, 134, 105, 5, 165],
//     actualData: [120, 82, 91, 154, 162, 140, 145, 161, 134, 105, 160, 165],
//   },
//   messages: {
//     expectedData: [200, 192, 120, 144, 160, 130, 140, 161, 134, 105, 160, 165],
//     actualData: [180, 160, 151, 106, 145, 150, 130, 161, 134, 105, 160, 165],
//   },
//   purchases: {
//     expectedData: [80, 100, 121, 104, 105, 90, 100, 161, 134, 105, 160, 165],
//     actualData: [120, 90, 100, 138, 142, 130, 130, 161, 134, 105, 160, 165],
//   },
//   shoppings: {
//     expectedData: [130, 140, 141, 142, 145, 150, 160, 161, 134, 105, 160, 165],
//     actualData: [120, 82, 91, 154, 162, 140, 130, 161, 134, 105, 160, 165],
//   },
// };

export default {
  name: 'DashboardAdmin',
  components: {
    PanelGroup,
    LineChart,
    PieChart,
  },
  data() {
    return {
      // lineChartData: lineChartData.newVisitis,
      lineChartData: {
        expectedData: [],
        actualData: [],
      },
      reportData: {},
      reportCategory: {},
      reportBulan: null,
      status: false,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { data, item, bulan } = await reportingResource.list(this.listQuery);
      this.reportData = data;
      this.reportCategory = item;
      this.reportBulan = bulan;
      this.lineChartData.expectedData = this.reportBulan.map(a => a.data);
      this.lineChartData.actualData = this.reportBulan.map(a => a.data);
      console.log(this.lineChartData.expectedData);
      console.log(this.lineChartData.actualData);
      this.status = true;
    },
    handleSetLineChartData(type) {
      this.lineChartData.expectedData = this.reportBulan.map(a => a.data);
      this.lineChartData.actualData = this.reportBulan.map(a => a.data);
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
