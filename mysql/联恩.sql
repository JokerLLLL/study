邬伟丽 2-9 11:48:26
这个是陈伟写的sql，你等会看看，我目前看到就是数量实际是对的，只是状态不一致，不应该当作没有入

邬伟丽 2-9 12:16:18
（核查逻辑：退货入库单据实际收货数量小于预计收货数量，且入库单状态已完成，且已退款数据）

SELECT * FROM(WITH
a as (
SELECT w.platformId,w.warehouse,w.id,adl.productId,sum(adl.quantity) as 'quantity',
-- adl.stockProductStatus,
w.rmaId FROM uco.Warehousing w
LEFT JOIN uco.WarehousingAdvancedLine adl ON adl.warehousingId = w.id AND adl.isEnable = 1
WHERE -- w.platformId in ('100074')
w.platformId in ('100778','100770','100785','100786','100785','100786','100779','100814','100823','100770','100830','100830','100830','100831','100831','100832','100832','100832','100778','100844','100778','100846','100864','100864','100864','100864','100864','100865','100865','100866','100863','100853','100853','100832','100864','100879','100879','100879','100879','100880','100880','100885','100885','100885','100888','100888','100888','100888','100814','100901','100901','100909','100909','100864','100864','100888','100888','100921','100922','100885','100901','100957','100888','100814','100865','100866','100921','100922','100957','100958','100968','100968','100976','100976','100975','100970') AND w.type = 20 AND w.status = 3
-- AND w.id = 1400000578
GROUP BY w.id,adl.productId-- ,adl.stockProductStatus
),
b as (
SELECT w.platformId,w.warehouse,w.id,adl.productId,sum(adl.quantity) as 'quantity'
-- ,adl.stockProductStatus
FROM uco.Warehousing w
LEFT JOIN uco.WarehousingActualLine adl ON adl.warehousingId = w.id AND adl.isEnable = 1
WHERE -- w.platformId in ('100074')
w.platformId in ('100778','100770','100785','100786','100785','100786','100779','100814','100823','100770','100830','100830','100830','100831','100831','100832','100832','100832','100778','100844','100778','100846','100864','100864','100864','100864','100864','100865','100865','100866','100863','100853','100853','100832','100864','100879','100879','100879','100879','100880','100880','100885','100885','100885','100888','100888','100888','100888','100814','100901','100901','100909','100909','100864','100864','100888','100888','100921','100922','100885','100901','100957','100888','100814','100865','100866','100921','100922','100957','100958','100968','100968','100976','100976','100975','100970') AND w.type = 20 AND w.status = 3
-- AND w.id = 1400000578
GROUP BY w.id,adl.productId-- ,adl.stockProductStatus
)

SELECT wa.name as 'warehouse',pf.name as 'platform',a.id as 'warehousingId',a.rmaId,a.quantity-IFNULL(b.quantity,0) as '差的数量',p.productCode,p.salePrice,(a.quantity-IFNULL(b.quantity,0))*p.salePrice as 'totalPrice',-- SUM(a.quantity) as '预计收货数量',SUM(IFNULL(b.quantity,0)) as '实际收货数量',
so.platformOrderId,rma.`status`,rma.finishAt,IF(rma.deliveryId = pa.deliveryId,'原单','非原单') as 'type',tbso.refundStatus,so.id as 'salesOrderId' FROM a
LEFT JOIN b ON b.id = a.id AND b.productId = a.productId -- AND a.stockProductStatus = b.stockProductStatus
LEFT JOIN uco.ReturnMerchandiseAuthorization rma ON rma.id = a.rmaId
LEFT JOIN uco.SalesOrder so ON so.id = rma.salesOrderId
LEFT JOIN uco.RmaAction ra ON ra.rmaId = rma.id
LEFT JOIN uco.Shipment s on s.salesOrderId = so.id
LEFT JOIN uco.Package pa ON pa.shipmentId = s.id
LEFT JOIN uco.TbSubOrder tbso ON tbso.tradeMainOrderId = so.platformOrderId
LEFT JOIN uco.Warehouse wa ON wa.wKey =a.warehouse
LEFT JOIN uco.Platform pf ON pf.pKey = a.platformId
LEFT JOIN uco.Product p ON p.id = a.productId
WHERE a.quantity-IFNULL(b.quantity,0) <> 0 AND rma.`status` = 11
GROUP BY a.id,a.rmaId,a.productId
)m



