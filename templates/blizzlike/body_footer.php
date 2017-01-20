                                                            
                                                            <!-- Component body END -->
                                                            </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div id="cnt-bot">
                                                        <div>
                                                          <div>&nbsp;</div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </td>
												<?php 
													if((empty($_GET['p']) || $_GET['p'] == "frontpage") && !isset($_GET['module']))
													{
														echo "<td valign=\"top\">";
														if($Config->get('enable_cache') == 1)
														{	
															if($Core->isCached($Template['number']."_bodyright_".$GLOBALS['user_cur_lang']))
															{
																$Contents = $Core->getCache($Template['number']."_bodyright_".$GLOBALS['user_cur_lang']);
																echo $Contents;
															}
															else
															{
																ob_start();
																	include($Template['script_path'].'/body_right.php');
																$Contents = ob_get_flush();
																$Core->writeCache($Template['number']."_bodyright_".$GLOBALS['user_cur_lang'], $Contents);
															}											
														}
														else
														{
															include($Template['script_path'].'/body_right.php');
														}
														echo "</td>";
													} 
												?>
                                                </tr>
                                              </table>                      
                                            </div>
                                          </div>
                                        </div>
                                        <div style="clear: both; font-size: 1px;">&nbsp;</div>
                                        <center>
                                          <div id="copyright">
										  <div id="blizzlogo-bot">
                                              <img alt="Blizzard.com" border="0" src="<?php echo $Template['path'];?>/images/bot-blizzlogo.gif"/></div>
                                            <span class="textlinks">
                                            <small>
												<?php echo $lang['pagegenerated'];?> <?php echo round(PAGE_LOAD_TIME, 4);?> sec.
												Query's: (RDB: <?php echo $DB->_statistics['count']; ?>,
												WDB: <?php echo $WDB->_statistics['count']?>,
												CDB: <?php echo $CDB->_statistics['count']?>)<br/>
												<b>&copy; <?php echo (string)$Template['copyright']; ?></b>
												<br /><b><?php echo $Core->copyright; ?></b>
												<br/>
												<a href="http://validator.w3.org/check?uri=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>">Validate XHTML</a> |
												<a href="http://jigsaw.w3.org/css-validator/validator?uri=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>">Validate CSS</a> |
												<a href="http://validator.w3.org/feed/check.cgi?url=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].(str_replace('index.php','',$_SERVER['PHP_SELF'])).'core/cache/rss/news.xml'); ?>">Validate RSS</a>
                                            </small>
											</span>
											<br><br><br>
                                          </div>
                                        </center>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <div id="main-bottom">
                                        <div>
                                          <div>
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <div style="position: relative; z-index: 10;">
                              <img style="position: absolute; top: -445px; left: -243px;" alt="statue" src="./<?php echo $Template['path']; ?>/images/statue.png"/></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </center>
    <div id="ironframe" style="z-index: 11;"></div>
    <div id="pageend"></div>
  </body>
</html>