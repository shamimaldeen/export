<script type="text/javascript">
    $(function()
    {
        // Display the create invoice modal
        $('#modal-choose-products').modal('show');

        // Creates the invoice
        $('#select-products-confirm').click(function()
        {
            var products_lookup_ids = [];
            
            $("input[name='products_lookup_ids[]']:checked").each(function ()
            {
                products_lookup_ids.push(parseInt($(this).val()));
            });
            
            $.post("<?php echo site_url('products/process_products_selections'); ?>", {
                products_lookup_ids: products_lookup_ids
            }, function(data) {
                products = JSON.parse(data);

                for(var key in products) {
                    if ($('#item_table tr:last input[name=item_name]').val() !== '') 
					{
                        $('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
						$('#item_table tr:last input[name=item_name]').val(products[key].product_name);
						$('#item_table tr:last textarea[name=item_description]').val(products[key].product_description);
						$('#item_table tr:last input[name=item_price]').val(products[key].product_unitprice);
						$('#item_table tr:last input[name=item_quantity]').val('1');
						$('#item_table tr:last input[name=item_discount]').val('0.00');
                    }
					else
					{
						$('#item_table tr:last input[name=item_name]').val(products[key].product_name);
						$('#item_table tr:last textarea[name=item_description]').val(products[key].product_description);
						$('#item_table tr:last input[name=item_price]').val(products[key].product_unitprice);
						$('#item_table tr:last input[name=item_quantity]').val('1');
						$('#item_table tr:last input[name=item_discount]').val('0.00');
					}
                    $('#modal-choose-products').modal('hide');
					calculateInvoiceAmounts();
                }
            });
        });
    });

</script>
<div id="modal-choose-products" class="modal">
	<form class="form-horizontal">
		<div class="modal-header">
			<a data-dismiss="modal" class="close">&times;</a>
			<h3>Add items from products</h3>
		</div>
		<div class="modal-body">
			
            <table class="table table-bordered ">
                <tr class="table_header">
                    <th></th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th class="text-right">Price</th>
                </tr>
                <?php foreach ($products->result_array() as $count=>$product) { ?>
                <tr>
                    <td><input type="checkbox" name="products_lookup_ids[]" value="<?php echo $product['product_id']; ?>"></td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo limit_text($product['product_description'], 30); ?></td>
                    <td class="text-right"><?php echo format_amount($product['product_unitprice'], 2); ?></td>
                </tr>
                <?php } ?>
            </table>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" id="select-products-confirm" type="button"><i class="fa fa-check"></i> Add Products</button>
			<button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
		</div>
	</form>
</div>