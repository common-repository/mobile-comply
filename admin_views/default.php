
	   <div id="page">
            <header id="header">
                <table id="header_site_title">
                    <tr>
                        <td>
                            <h1><?php echo $site_title; ?></h1>

                        </td>
                    </tr>
                </table>

                <a href="http://localhost:8888/mobilecomply">
                    <img src="<?php echo $logo_url; ?>" alt="Mobilecomply very long title" id="header_logo" <?php if (empty($logo_url)) {
                        echo 'class="hidden"';
                    } ?>/>
                </a>
            </header><!-- #header -->

            <div id="top_bar" <?php echo!$show_top_toolbar ? 'style="display:none;"' : ''; ?>>
                <div id="top_search" <?php echo!$show_top_toolbar_search ? 'style="display:none;"' : ''; ?>>

                    <form action="http://localhost:8888/mobilecomply" method="get">
                        <div class="text">
                            <input type="text" name="s" value=""/>
                        </div>
                        <input type="submit" name="search" value="Search" class="button"/>
                    </form>
                </div>

                <a href="#" id="navigation_button" class="active">
                    Navigation
                    <span class="triangle"></span>

                    <span class="triangle_shadow"></span>
                </a>
                <div id="primary_menu">
                    <div class="menu-sample-menu-container"><ul id="menu-sample-menu" class="menu"><li id="menu-item-22" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-22"><a href="http://localhost:8888/mobilecomply/?page_id=2">Sample Page</a></li>
                            <li id="menu-item-23" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-23"><a href="http://localhost:8888/mobilecomply/?cat=1">Uncategorized</a>
                                <ul class="sub-menu">
                                    <li id="menu-item-24" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24"><a href="http://localhost:8888/mobilecomply/?page_id=2">Sample Page</a></li>
                                </ul>
                            </li>

                        </ul></div>                    </div>
                <div class="clear"></div>
            </div>

            <div id="main">
                <div id="primary">
                    <div id="content" role="main">


                        <article id="post-9" class="post-9 post type-post status-publish format-standard sticky hentry category-uncategorized">
                            <header class="entry-header">
                                <div class="sticky_image">

                                    <a href="http://localhost:8888/mobilecomply/?p=9" title="Another post for testing" >
                                        <img width="598" src="<?php echo MobileComply::get_dir_plugin_url() . 'images/DSC_1586.jpg'; ?>" class="attachment-600x3000 wp-post-image" alt="DSC_1766" title="DSC_1766" />                    
                                    </a>
                                    <div class="clear"></div>
                                </div>
                                <hgroup>
                                    <div class="date">
                                        October<br/><span>5</span><br/>2011                    <div class="triangle"></div>
                                    </div>

                                    <h2 class="entry-title"><a href="http://localhost:8888/mobilecomply/?p=9" title="Permalink to Another post for testing" rel="bookmark">Very long post title for test</a></h2>
                                    <div class="author">by: admin</div>
                                </hgroup>
                            </header><!-- .entry-header -->

                            <div class="entry-summary">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum aliquam mauris eu scelerisque. Suspendisse blandit sapien dolor. Cras orci enim, viverra et volutpat et, elementum sit amet magna. [...]</p>

                            </div><!-- .entry-summary -->

                            <footer class="entry-meta">
                                <span class="cat-links">
                                    <span class="entry-utility-prep entry-utility-prep-cat-links">Posted in</span> <a href="http://localhost:8888/mobilecomply/?cat=1" title="View all posts in Uncategorized" rel="category">Uncategorized</a>                </span>
                            </footer><!-- #entry-meta -->
                        </article><!-- #post-9 -->

                        <article id="post-28" class="post-28 post type-post status-publish format-standard hentry category-uncategorized">

                            <header class="entry-header">
                                <h1 class="entry-title"><a href="http://localhost:8888/mobilecomply/?p=28" title="Permalink to Test" rel="bookmark">Test 1</a></h1>
                                <div class="date">October 6, 2011</div>
                                <div class="author">by: admin</div>
                            </header><!-- .entry-header -->

                            <div class="entry-summary">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum aliquam mauris eu scelerisque. Suspendisse blandit sapien dolor. Cras orci enim, viverra et volutpat et, elementum sit amet magna. [...]</p>
                            </div><!-- .entry-summary -->


                            <footer class="entry-meta">
                                <span class="cat-links">
                                    <span class="entry-utility-prep entry-utility-prep-cat-links">Posted in</span> <a href="http://localhost:8888/mobilecomply/?cat=1" title="View all posts in Uncategorized" rel="category">Uncategorized</a>                </span>
                            </footer><!-- #entry-meta -->
                        </article><!-- #post-28 -->

                        <article id="post-25" class="post-25 post type-post status-publish format-standard hentry category-uncategorized">
                            <header class="entry-header">

                                <h1 class="entry-title"><a href="http://localhost:8888/mobilecomply/?p=25" title="Permalink to Test 2" rel="bookmark">Test 2</a></h1>
                                <div class="date"></div>
                                <div class="author">by: admin</div>
                            </header><!-- .entry-header -->

                            <div class="entry-summary">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum aliquam mauris eu scelerisque. Suspendisse blandit sapien dolor. Cras orci enim, viverra et volutpat et, elementum sit amet magna. [...]</p>
                            </div><!-- .entry-summary -->

                            <footer class="entry-meta">

                                <span class="cat-links">
                                    <span class="entry-utility-prep entry-utility-prep-cat-links">Posted in</span> <a href="http://localhost:8888/mobilecomply/?cat=1" title="View all posts in Uncategorized" rel="category">Uncategorized</a>                </span>
                            </footer><!-- #entry-meta -->
                        </article><!-- #post-25 -->

                    </div><!-- #content -->
                </div><!-- #primary -->
                <aside id="calendar-4" class="widget widget_calendar"><h3 class="widget-title">Calendar</h3><div id="calendar_wrap"><table id="wp-calendar">

                            <caption>October 2011</caption>
                            <thead>
                                <tr>
                                    <th scope="col" title="Monday">M</th>
                                    <th scope="col" title="Tuesday">T</th>
                                    <th scope="col" title="Wednesday">W</th>
                                    <th scope="col" title="Thursday">T</th>

                                    <th scope="col" title="Friday">F</th>
                                    <th scope="col" title="Saturday">S</th>
                                    <th scope="col" title="Sunday">S</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>

                                    <td colspan="3" id="prev"><a href="http://localhost:8888/mobilecomply/?m=201109" title="View posts for September 2011">&laquo; Sep</a></td>
                                    <td class="pad">&nbsp;</td>
                                    <td colspan="3" id="next" class="pad">&nbsp;</td>
                                </tr>
                            </tfoot>

                            <tbody>
                                <tr>

                                    <td colspan="5" class="pad">&nbsp;</td><td>1</td><td>2</td>
                                </tr>
                                <tr>
                                    <td>3</td><td>4</td><td><a href="http://localhost:8888/mobilecomply/?m=20111005" title="Another post for testing">5</a></td><td><a href="http://localhost:8888/mobilecomply/?m=20111006" title="Some new post without image, Test 2, Test">6</a></td><td>7</td><td>8</td><td>9</td>

                                </tr>
                                <tr>
                                    <td id="today">10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td>
                                </tr>
                                <tr>

                                    <td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td>
                                </tr>
                                <tr>
                                    <td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td>

                                </tr>
                                <tr>
                                    <td>31</td>
                                    <td class="pad" colspan="6">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table></div></aside>
            </div><!-- #main -->

            <footer id="footer" class="footer-4" <?php echo!$show_footer_toolbar ? 'style="display:none;"' : ''; ?>>
                <a href="http://localhost:8888/mobilecomply" class="button">
                    Home                </a>
                <a href="tel:+380638532498" class="button">

                    Call                    </a>
                <a href="http://maps.google.com/maps/ms?msid=214773080282408578276.0004aeb56cc4c5e076387&msa=0" class="button" target="_blank">
                    Map                    </a>
                <a href="http://localhost:8888/mobilecomply/?page_id=2" class="button">
                    Contact                    </a>
                <div id="footer_copyright" <?php if (empty($footer_copyright)) {
                    echo 'class="hidden"';
                } ?>>
                    &copy; <?php echo $footer_copyright; ?>
                </div>
            </footer><!-- #footer -->
        </div><!-- #page -->