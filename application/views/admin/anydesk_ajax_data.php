<div class="card mb-5">
    <div class="card-body custom-data-table cus-table-width">
        <table class="table table-responsive" style="width: 100%;" id="datatable-scroller">
            <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Store Name
                        </th>
                        <th>
                            Store Owner Name
                        </th>
                        <th>
                            Client Name
                        </th>
                        <th>
                            Store Phone Number
                        </th>
                        <th>
                            Store Email
                        </th>
                        <th>
                            AnyDesk
                        </th>
                        <th>
                            Windows PIN
                        </th>
                        <th>
                            Store's GMAIL
                        </th>
                        <th>
                            Password
                        </th>
                        <th>
                            Seller Central Email
                        </th>
                        <th>
                            Seller Central PW
                        </th>
                        <th>
                            Businesss Prime Email
                        </th>
                        <th>
                            Business Prime PW
                        </th>
                        <th>
                            Ecom email
                        </th>
                        <th>
                            Ecom PW
                        </th>
                        <th>
                            Personal Emails for Billing/Invoicing
                        </th>
                        <th>
                            Store Initial
                        </th>
                        <th>
                            Welcome Call Date
                        </th>
                        <th>
                            Accounting Email
                        </th>
                        
                    </tr>
                </thead>
            <tbody>
                <?php if (!empty($anyDeskDatas)): foreach ($anyDeskDatas as $key => $anyDeskData): ?>
                    <tr>    
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->store_name ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->Store_owner_Name ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->client_Name ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->store_phone_number ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->client_personal_email ?>
                            </td>
                            <td>
                                <p><?php echo $anyDeskData->anydesk_id ?></p>
                            </td>
                            <td>
                                <?php echo $anyDeskData->windows_pin ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->store_gmail ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->other_password ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->seller_central_email ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->seller_central_pw ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->businesss_prime_email ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->business_prime_pw ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->ecom_email ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->ecom_pw ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->personal_emails ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->store_initial ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->welcome_call_date ?>
                            </td>
                            <td>
                                <?php echo $anyDeskData->accounting_email ?>
                            </td>
                        </tr>
                    </tr>
                <?php endforeach;?>

                <?php else: ?>
                <tr>
                    <td colspan="18">
                        <div class="alert alert-warning"><i class="fa fa-info-circle"></i> There are currently no data found.</div>
                    </td>
                </tr>
                <?php endif?>
            </tbody>
        </table>
    </div>
</div>
