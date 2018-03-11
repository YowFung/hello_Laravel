$(document).ready(function() {
    //“基本信息界面中”点击“修改信息”按钮
    $('#change_info').click(function() {
        $('.foundation-data').css('display', 'none');
        $('.foundation-edit').css('display', 'block');
        $('#save_info').css('display', 'inline');
        $('#cancel_change').css('display', 'inline');
        $('#change_info').css('display', 'none');
    });

    //基本信息界面中点击“保存”按钮
    $('#save_info').click(function() {
        $('.foundation-data').css('display', 'block');
        $('.foundation-edit').css('display', 'none');
        $('#save_info').css('display', 'none');
        $('#cancel_change').css('display', 'none');
        $('#change_info').css('display', 'inline');
    });

    //基本信息界面中点击“取消”按钮
    $('#cancel_change').click(function() {
        $('.foundation-data').css('display', 'block');
        $('.foundation-edit').css('display', 'none');
        $('#save_info').css('display', 'none');
        $('#cancel_change').css('display', 'none');
        $('#change_info').css('display', 'inline');
    });

    //显示标签
    function showLabel() {

    }

    //显示编辑框
    function showEdit() {

        //显示组件
        $('.foundation-info-edit').css('display', 'inline');
        $('#save_info').css('display', 'inline');
        $('#cancel_change').css('display', 'inline');

        //隐藏组件
        $('.foundation-info-label').css('display', 'none');
        $('#change_info').css('display', 'none');
    }
});