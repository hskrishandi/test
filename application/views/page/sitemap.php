<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
	   Sitemap
	<?php endblock(); ?>


    <?php startblock('css'); ?>
    <?php echo get_extended_block(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'sitemap.css'); ?>" media="all" />
	<?php endblock(); ?>


<?php startblock('content'); ?>
<div id="static-page">
    <h2>Sitemap</h2>
    <div class="sitemap">
        <div class="left_table">
            <table>
                <tr>
                    <td class="thead"><span class="thead"><a href="<?php echo base_url('home');?>">Home</a></span></td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li><a href="<?php echo base_url('home/manual');?>">i-MOS User Manual</a></li>
                            <li><a href="http://ngspice.sourceforge.net/docs.html">Ngspice Manual</a></li>
                            <li><a href="<?php echo base_url('home/activities');?>">i-MOS Activities</a></li>
                            <li><a href="<?php echo base_url('home/user_experience');?>">User Experience</a></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="thead"><a href="<?php echo base_url('modelsim');?>">Models</a></td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <?php foreach($model_info as $row):?>
                                <li><a href="<?php echo base_url('modelsim/model/'.$row->id);?>"><?php echo $row->short_name; ?></a></li>
                                <!--&nbsp;&nbsp;&nbsp;&nbsp; Description<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; Parameters<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Instance Parameters<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Model Parameters<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; Biasing<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; General Biasing<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Benchmarking<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; Output Filter<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; Simulation Results<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp; Comments<br/>-->
                            <?php endforeach;?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="thead"><a href="<?php echo base_url('txtsim');?>">Simulation</a></td>
                </tr>
                <tr>
                    <td><ul>
                        <li><a href="<?php echo base_url('txtsim#netlistmode');?>">Netlist</a></li>
                        <li><a href="<?php echo base_url('txtsim#simMode');?>">Schematic</a></li>
                        <li><a href="<?php echo base_url('txtsim#textMode');?>">Raw Input</a></li>
                        <li><a href="<?php echo base_url('txtsim#rawResult');?>">Raw Data</a></li>
                        <li><a href="<?php echo base_url('txtsim#graphResult');?>">Graph Result</a></li>
                        <li><a href="<?php echo base_url('txtsim#log');?>">Log</a></li>
                        <li><a href="<?php echo base_url('txtsim');?>">User Library</a></li>
                    </ul></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="thead"><a href="<?php echo base_url('developer');?>">Developer</a></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="right_table">
            <table>
                <tr>
                    <td class="thead"><a href="<?php echo base_url('discussion');?>">Discussion</a></td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li><a href="<?php echo base_url('discussion/posting');?>">Post</a></li>
                            <li><a href="<?php echo base_url('discussion/blog');?>">Blog</a></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="thead"><span class="thead"><a href="<?php echo base_url('resources');?>">Resources</a><a href="<?php echo base_url('home');?>"></a></span></td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li><a href="<?php echo base_url('resources/news');?>">News</a></li>
                            <li><a href="<?php echo base_url('resources/events');?>">Events</a></li>
                            <li><a href="<?php echo base_url('resources/articles');?>">Articles</a></li>
                            <li><a href="<?php echo base_url('resources/groups');?>">Organizations</a></li>
                            <li><a href="<?php echo base_url('resources/models');?>">Device Models</a></li>
                            <li><a href="<?php echo base_url('resources/tools');?>">Tools</a></li>
                        </ul></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="thead"><a href="<?php echo base_url('account');?>">Accounts</a><a href="<?php echo base_url('simulation');?>"></a></td>
                    </tr>
                    <tr>
                        <td><ul>
                            <li><a href="<?php echo base_url('account/create');?>">Registration</a></li>
                            <li><a href="<?php echo base_url('account/newPass');?>">Request new password</a></li>
                            <li><a href="<?php echo base_url('account/infoUpdate');?>">Account Update</a></li>
                            <li><a href="<?php echo base_url('account/changePass');?>">Change Password</a></li>
                        </ul></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="thead"><a href="<?php echo base_url('contacts');?>">Contacts</a><a href="<?php echo base_url('developer');?>"></a></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
	<?php endblock(); ?>

<?php end_extend(); ?>
