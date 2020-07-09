<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreateForm"
      >Tambah</el-button>
    </div>
    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80" type="index" />
      <el-table-column align="center" label="Nama Bank">
        <template slot-scope="scope">
          <span>{{ scope.row.bank_name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="No.Rekening">
        <template slot-scope="scope">
          <span>{{ scope.row.account_number }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Atas nama">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEditForm(scope.row.id, scope.row.account_number);"
          >Edit</el-button>
          <el-button
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.account_number);"
          >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog :title="formTitle" :visible.sync="bankFormVisible">
      <div class="form-container">
        <el-form
          ref="categoryForm"
          :model="currentBank"
          label-position="left"
          label-width="150px"
          style="max-width: 500px;"
        >
          <el-form-item label="Nama Bank" prop="bank_name">
            <el-select v-model="currentBank.bank_name" class="filter-item" placeholder="Please select">
              <el-option v-for="item in bankOptions" :key="item.value" :label="item.label" :value="item.value" />
            </el-select>
          </el-form-item>
          <el-form-item label="No.Rekening" prop="account_number">
            <el-input v-model="currentBank.account_number" />
          </el-form-item>
          <el-form-item label="Atas nama" prop="name">
            <el-input v-model="currentBank.name" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="bankFormVisible = false">Cancel</el-button>
          <el-button type="primary" @click="handleSubmit()">Confirm</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
const bankResource = new Resource('banks');

export default {
  name: 'CategoryList',
  data() {
    return {
      list: [],
      loading: true,
      bankFormVisible: false,
      currentBank: {},
      formTitle: '',
      bankOptions: [{
        value: 'Bank Mandiri',
        label: 'Bank Mandiri',
      },
      {
        value: 'Bank Negara Indonesia (BNI)',
        label: 'Bank Negara Indonesia (BNI)',
      },
      {
        value: 'Bank Rakyat Indonesia (BRI)',
        label: 'Bank Rakyat Indonesia (BRI)',
      },
      {
        value: 'Bank Tabungan Negara (BTN)',
        label: 'Bank Tabungan Negara (BTN)',
      },
      ],
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await bankResource.list({});
      this.list = data;
      this.loading = false;
    },
    handleSubmit() {
      if (this.currentBank.id !== undefined) {
        bankResource
          .update(this.currentBank.id, this.currentBank)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Category info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.bankFormVisible = false;
          });
      } else {
        bankResource
          .store(this.currentBank)
          .then(response => {
            this.$message({
              message:
                'New category ' +
                this.currentBank.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentBank = {
              bank_name: '',
              account_number: '',
              name: '',
            };
            this.bankFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    handleCreateForm() {
      this.bankFormVisible = true;
      this.currentBank = {
        bank_name: '',
        account_number: '',
        name: '',
      };
    },
    handleEditForm(id) {
      this.formTitle = 'Edit category';
      this.currentBank = this.list.find(category => category.id === id);
      this.bankFormVisible = true;
    },
    handleDelete(id, name) {
      this.$confirm(
        'Ini akan menghapus kategori secara permanen ' + name + '. Lanjutkan?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          bankResource
            .destroy(id)
            .then(response => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.getList();
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled',
          });
        });
    },
  },
};
</script>
