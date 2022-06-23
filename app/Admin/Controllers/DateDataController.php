<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\DateData;

class DateDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '會員資料';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DateData);

        //$grid->column('id', __('ID'))->sortable();

        $grid->column('username', __('會員名稱'));
        $grid->column('identity', __('身分證'));
        $grid->column('phone', __('手機號'));
        $grid->column('gender', __('性別'));
        $grid->column('consultant', __('顧問'));
        $grid->column('plan', __('方案別'));
        $grid->column('live_place', __('居住地'));
        $grid->column('birth_place', __('出生地'));
        $grid->column('for_light_plan', __('輕方案可看'));
        $grid->column('data_url', __('資料連結'));
        $grid->column('data_url_simple', __('資料連結刪減版'));
        $grid->column('record', __('紀錄'));
  
        // $grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));

        $grid->filter(function($filter){

            $filter->disableIdFilter();
          

        });

        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            //$actions->disableEdit();
            //$actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                //$batch->disableDelete();
            });
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(DateData::findOrFail($id));

        $show->field('id', __('ID'));
      
        $show->panel()
        ->tools(function ($tools) {
            // $tools->disableEdit();
            // $tools->disableList();
            // $tools->disableDelete();
        });;
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DateData);

        $form->display('id', __('ID'));
        $form->text('username', __('會員名稱'));
        $form->text('identity', __('身分證'));
        $form->text('phone', __('手機號'));
        $form->text('gender', __('性別'));
        $form->text('consultant', __('顧問'));
        $form->text('plan', __('方案別'));
        $form->text('live_place', __('居住地'));
        $form->text('birth_place', __('出生地'));
        $form->text('for_light_plan', __('輕方案可看'));
        $form->text('data_url', __('資料連結'));
        $form->text('data_url_simple', __('資料連結刪減版'));
        $form->text('record', __('紀錄'));
      
        // $form->display('created_at', __('建立時間'));
        // $form->display('updated_at', __('更新時間'));
        $form->tools(function (Form\Tools $tools) {
            //$tools->disableList();
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        return $form;
    }
}
