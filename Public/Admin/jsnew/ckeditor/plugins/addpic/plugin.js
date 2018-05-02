(function () {
	//Section 1 : 按下自定义按钮时执行的代码
	var a = {
			exec: function (editor) {
				cksimpleload(editor);
			}
	},
	b = 'addpic';
	CKEDITOR.plugins.add(b, {
		init: function (editor) {
			editor.addCommand(b, a);
			editor.ui.addButton('addpic', {
				label: '单图上传',
				icon: this.path + 'addpic.png',
				command: b
			});
		}
	});
})();	