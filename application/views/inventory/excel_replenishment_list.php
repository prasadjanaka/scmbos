      <table cellspacing="0" width="100%" border="1">
        <thead>
          <tr>
            <th align="left"><?php echo $zone?></th>
            <th align="left">&nbsp;</th>
            <th colspan="4" align="left">Replenish To:</th>
            <th align="left">&nbsp;</th>
            <th align="left">&nbsp;</th>
            <th align="left">Location</th>
            <th align="left">Available</th>
            <th align="left">Required</th>
            <th align="left">&nbsp;</th>
            <th align="left">&nbsp;</th>
            <th colspan="3" align="left">Moved from</th>
            <th align="left">Notes</th>
          </tr>
          <tr>
            <th align="left">DateTime</th>
            <th align="left">Zone</th>
            <th align="left">Sub Zone</th>
            <th align="left">Location</th>
            <th align="left">Product ID</th>
            <th align="left">Description</th>
            <th align="left">ROL</th>
            <th align="left">PPQ</th>
            <th align="left">Inv</th>
			<th align="left">Inv</th>
            <th align="left">Qty</th>
            <th align="left">Zone</th>
            <th align="left">Location</th>
            <th align="left">Qty</th>
            <th align="left">By</th>
			<th align="left">Date</th>            
          </tr>
        </thead>
        <tbody>
          <?php 
		  $loop = 1;
		  foreach($replenishments->result() as $ci){?>
          <tr>
            <td align="left"><?php echo $ci->datetime_created?></td>
            <td align="left"><?php echo $ci->zone?></td>
            <td align="left"><?php echo $ci->sub_zone?></td>
            <td align="left"><?php echo $ci->location?></td>
            <td align="left"><?php echo $ci->product_id?></td>
            <td align="left"><?php echo $ci->description?></td>
            <td align="left"><?php echo $ci->min_reorder_level?></td>
            <td align="left"><?php echo $ci->ppq?></td>
            <td align="left"><?php echo $ci->current_inventory_in_location?></td>
            <td align="left"><?php echo $ci->current_inventory?></td>	
            <td align="left"><?php echo $ci->quantity_required?></td>
            <td align="left"><?php echo $ci->replenished_from_zone?></td>
            <td align="left"><?php echo $ci->replenished_from_location?></td>
            <td align="left"><?php echo $ci->quantity_replenished?></td>
            <td align="left"><?php echo $ci->user_name_replenished?></td> 
            <?php if($ci->rep_status=="COMPLETED"){?>
            <td align="left"><?php echo $ci->datetime_replenished?></td>
            <?php }else{?>
            <td align="left"></td>            
            <?php }?>            
          </tr>
          <?php 
		  $loop++;
		  }
		  
		  ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
