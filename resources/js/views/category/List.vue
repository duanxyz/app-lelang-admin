<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        Tambah
      </el-button>
    </div>
    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80" type="index" />
      <el-table-column align="center" label="Name">
        <template slot-scope="scope">
          <span>{{ scope.row.category_name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id, scope.row.category_name);">
            Edit
          </el-button>
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.category_name);">
            Delete
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog :title="formTitle" :visible.sync="categoryFormVisible">
      <div class="form-container">
        <el-form ref="categoryForm" :model="currentCategory" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Name" prop="category_name">
            <el-input v-model="currentCategory.category_name" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="categoryFormVisible = false">
            Cancel
          </el-button>
          <el-button type="primary" @click="handleSubmit()">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import Resource from '@/api/resource';
const categoryResource = new Resource('categories');

export default {
  name: 'CategoryList',
  data() {
    return {
      list: [],
      loading: true,
      categoryFormVisible: false,
      currentCategory: {},
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await categoryResource.list({});
      this.list = data;
      this.loading = false;
    },
    handleSubmit() {
      if (this.currentCategory.id !== undefined) {
        categoryResource.update(this.currentCategory.id, this.currentCategory).then(response => {
          this.$message({
            type: 'success',
            message: 'Category info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.categoryFormVisible = false;
        });
      } else {
        categoryResource
          .store(this.currentCategory)
          .then(response => {
            this.$message({
              message: 'New category ' + this.currentCategory.category_name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentCategory = {
              category_name: '',
            };
            this.categoryFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    handleCreateForm() {
      this.formTitle = 'Create new category';
      this.categoryFormVisible = true;
      this.currentCategory = {
        category_name: '',
      };
    },
    handleEditForm(id) {
      this.formTitle = 'Edit category';
      this.currentCategory = this.list.find(category => category.id === id);
      this.categoryFormVisible = true;
    },
    handleDelete(id, name) {
      this.$confirm('Ini akan menghapus kategori secara permanen ' + name + '. Lanjutkan?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        categoryResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },
  },
};
</script>
