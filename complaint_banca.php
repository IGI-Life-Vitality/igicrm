<?php
    $objProd = new Product();
    $objComplaint = new Complaint();
?>

<style type="text/css">
    .panel-heading .nav-tabs{
        margin: 0px !important;
    }
    .nav-pills1 {
        margin: 2px 0px 0px 0px !important;
        color: #FFF !important;
        background: #033765 !important;
    }

    .nav-pills1 > li + li {
        margin-left: 5px;
        background: #033765 !important;
    }

    .nav .nav-pills1 > li > a:focus, .nav > li > a:hover {
        color: #333;
        background: #fafafa;
        border-radius: 0px !important;
    }
</style>

<div class="row">
    <form class="form-horizontal" action="#" method="POST">
        <fieldset>
            <div class="panel panel-default panel-with-tabs">
                <div class="panel-heading">
                    <ul id="myTab1" class="nav nav-pills nav-pills1 nav-tabs-inverse pull-right">
                        <li class="active">
                            <a id="SubtabBancaIndividual" href="#nav-tab-BancaIndividual" data-toggle="tab">Banca - Individual</a>
                        </li>
                        <li class="">
                            <a id="SubtabBancaBank" href="#nav-tab-BancaBank" data-toggle="tab">Banca - Bank</a>
                        </li>
                    </ul>
                    <h4>Bancassurance Complaints</h4>
                </div>

                <!-- Begin Banca - Individual -->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-tab-BancaIndividual">
                        <?php include('complaint_banca_individual.php'); ?>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-BancaBank">
                        <?php include('complaint_banca_bank.php'); ?>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>