家政公司管理
	查看所有家政公司--shopmanager/shop-manager/index
		查询、重置、编辑、封号、添加
	添加新家政--shopmanager/shop-manager/create

门店管理
	查询所有门店--shop/shop/index
		查询、重置、编辑、封号、添加、删除
	添加新门店--shop/shop/create

阿姨管理
	查看所有阿姨--worker/worker
		查询、重置、查看、审核、删除、添加、批量休假、批量事假
	录入新阿姨--worker/worker/create

客户管理
	查看所有客户--customer/customer/index
		查询、重置、添加、封号、解除封号、客户详情（点击客户电话）
	评价列表--customer/customer-comment/index
		查询、重置
	评价标签管理--customer/customer-comment-tag/index
		添加、编辑、导出

订单管理
	查看所有订单--order/order/index
		搜索、查看订单、投诉、取消订单
	创建新订单--order/order/create
	人工派单--order/order/assign
		开工啦
	智能派单--order/auto-assign/index
		连接派单服务、开始自动派单、启动派单服务、停止自动派单、跟新配置（即时生效）、重新启动
	订单投诉--order/order-complaint/index
		查询、申请赔偿

运营管理
服务管理
	服务项目和类型管理--operation/operation-category/index
		增加服务类型、增加服务项目、规格管理、查看、编辑、删除、增加、导出
	城市和商圈管理--operation/operation-city/index
		搜索、增加、查看、商圈列表、增加、编辑、删除、导出
	已开通城市管理--operation/operation-city/opencity
		上线城市、编辑
	精品保洁管理--operation/operation-selected-service/index
		增加、查看、编辑、删除、导出
CMS管理
	应用平台管理--operation/operation-platform
		创建平台、查看、编辑、删除、平台版本、创建版本
	广告位置管理--operation/operation-advert-position/index
		搜索、创建广告位置、查看、编辑、删除
	广告内容管理--operation/operation-advert-content/index
		创建广告内容、搜索、查看、编辑、删除
	已发布广告管理--operation/operation-advert-release/index
		发布广告、查看
优惠券管理
	优惠券列表--operation/coupon/coupon/index
		查询、重置、新增优惠券、详情、绑定
	添加新优惠券--operation/coupon/coupon/create
启动页管理--operation/operation-boot-page/index
	增加、查看、编辑、删除
阿姨任务管理--operation/worker-task/index
	查询、添加
服务卡管理
	服务卡信息管理--operation/operation-service-card-info/index
		查询、重置、增加、查看、编辑、删除
	服务卡销售记录--operation/operation-service-card-sell-record/index
		查询、重置
	服务卡客户关系--operation/operation-service-card-with-customer/index
		查询、重置
	服务卡消费记录--operation/operation-service-card-consume-record/index
		查询、重置

财务管理
对账管理
	渠道管理--finance/finance-pay-channel/index
		增加、查看、编辑
	配置对账表头--finance/finance-header/index
		确定、重置、添加、查看、编辑、删除
	开始对账--finance/finance-pop-order/index
		提交、重置、批量
	查看历史对账记录--finance/finance-record-log/index
		提交、重置
	对账记录详情--finance/finance-pop-order/billinfo
		提交、重置
	坏账管理--finance/finance-pop-order/bad
		提交、重置
结算管理
	自营结算--finance/finance-settle-apply/self-fulltime-worker-settle-index
			人工结算、重置、查询、查看、审核通过、审核不通过
小家政结算
	门店结算--finance/finance-shop-settle-apply/index
		查询、重置、人工结算
	阿姨结算--finance/finance-settle-apply/self-fulltime-worker-settle-index
		人工结算、重置、查询
结算查询
	阿姨结算--finance/finance-settle-apply/query
		查询、重置、导出报表、导出
	门店结算--finance/finance-shop-settle-apply/query
		查询、重置、导出报表、导出
退款管理
	财务审核确认--finance/finance-refund/index
		查询、重置
	退款统计--finance/finance-refund/countinfo
		查询、重置、导出报表
赔偿管理
	财务确认赔偿--finance/finance-compensate/finance-confirm-index
		查询、重置、查看、确认打款、不通过、导出
	赔偿查询--finance/finance-compensate/index
		查询、重置、查看、更新、删除、导出
报表管理
	日报表管理--finance/finance-office-count/indexoffice
		提交、重置
发票管理