<?php

defined('_JEXEC') or die;




class ParkwayControllerBuilding extends JControllerAdmin
{
	
	protected $text_prefix = 'COM_PARKWAY_BUILDING';

	public function __construct($config = array()) {
            
            //$this->registerTask('deleteFactSheet', 'deleteFactSheet');
            
            parent::__construct($config);
        }
	

	public function getModel($name = 'Building', $prefix = 'ParkwayModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);
                
                return $model;
	}
        
        public function add(){
              //redirects user back to blog homepage with Cancellation Message
            $msg = JText::_( 'COM_PARKWAY_POST_ADDED' );
            $this->setRedirect( 'index.php?option=com_parkway&view=buildings', $msg );
        }
        
        /*
        public function apply(){
              //redirects user back to blog homepage with Cancellation Message
            $msg = JText::_( 'COM_PARKWAY_POST_APPLIED' );
            $this->setRedirect( 'index.php?option=com_parkway', $msg );
        }
        */
        
         public function save(){
              //redirects user back to blog homepage with Cancellation Message
            
            //get form variables
             
             $form = JRequest::getVar( 'jform','','post', 'array', JREQUEST_ALLOWHTML );
            
            $jinput = JFactory::getApplication()->input;
            $files = $jinput->files->get('jform'); 
            $file= $files['image'];
            $fileThumb= $files['imagethumb'];
            $pdfFile= $files['fact_sheet'];
             
            $stamp = time().rand(0,999).'-';
             
             $data =new stdClass();
                $data->id                   = $form['id'];
                $data->name                 = $form['name'];
                $data->property_id          = $form['property_id'];
                $data->widgetkit_id          = $form['widgetkit_id'];
                $data->address1             = $form['address1'];
                $data->address2             = $form['address2'];
                $data->city                 = $form['city'];
                $data->state                = $form['state'];
                $data->zip                  = $form['zip'];
                //$data->floor_size           = $form['floor_size'];
		$data->number_of_floors     = $form['number_of_floors'];
                $data->year_built           = $form['year_built'];
                $data->typical_floor_size   = $form['typical_floor_size'];
                $data->parking_ratio        = $form['parking_ratio'];
                $data->amenities            = $form['amenities'];
                $data->leed_cert            = $form['leed_cert'];
                $data->building_size        = $form['building_size'];
                $data->show_fact_sheet        = $form['show_fact_sheet'];
		
            //upload image
            if (!empty($file['name'])){
                $this->deleteImage(); //delete previousimage
                $data->image            = $stamp.$file['name'];
                
                $filename = JFile::makeSafe($file['name']); 

                $source = $file['tmp_name'];
                $destination = JPATH_ROOT . '/media/com_parkway/' . $stamp.$filename;
                if (JFile::upload($source, $destination)) 
                {

                }
 
            }
            //upload image thumbnail
            if (!empty($fileThumb['name'])){
                $this->deleteImageThumb(); //delete previousimage thumbnail
                $data->imagethumb            = $stamp.$fileThumb['name'];
                
                $filename = JFile::makeSafe($fileThumb['name']); 

                $source = $fileThumb['tmp_name'];
                $destination = JPATH_ROOT . '/media/com_parkway/' . $stamp.$filename;

                if (JFile::upload($source, $destination)) 
                {

                } 
            }
            
            //upload PDF file   
            if (!empty($pdfFile['name'])){
                $this->deleteFactSheet(); //delete previous fact sheet
                $data->fact_sheet                 = $stamp.$pdfFile['name'];
                
                $filename = JFile::makeSafe($pdfFile['name']); 

                $source = $pdfFile['tmp_name'];
                $destination = JPATH_ROOT . '/media/com_parkway/' . $stamp.$filename;
                if (JFile::upload($source, $destination)) 
                {

                }
                
                
            }
                
                
                $data->coordinates          = $form['coordinates']; 
                 
                $data->published            = $form['published'];
                        
                $db = JFactory::getDBO();
            

            //save to database
            if ($data->id == 0){
                
               
                $db->insertObject( '#__parkway_buildings', $data, id );
                
                 
            }else if ($data->id > 0){

                    $db->updateObject( '#__parkway_buildings', $data, id );
            }
            
            $msg = JText::_( 'COM_PARKWAY_POST_SAVED' );
            $this->setRedirect( 'index.php?option=com_parkway&view=buildings', $msg );
        }
      
        public function cancel(){
            

            //redirects user back to blog homepage with Cancellation Message
            $msg = JText::_( 'COM_PARKWAY_POST_CANCELLED' );
            $this->setRedirect( 'index.php?option=com_parkway&view=buildings' );

        }
        public function deleteFactSheet(){
            
            $form   = JRequest::getVar( 'jform','','post', 'array', JREQUEST_ALLOWHTML );
            $id     = $form['id'];
            
            //find factsheet
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__parkway_buildings');  
            $query->where('id = '.$id);
            
            $db->setQuery($query);
            $result = $db->loadObject();    
            
                      
            //delete file
            JFile::delete(JPATH_ROOT.'/media/com_parkway/'.$result->fact_sheet);
            
            //delete factsheet in database
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->update('#__parkway_buildings');
            $query->set('fact_sheet = "" ');  
            $query->where('id = '.$id);
            
            $db->setQuery($query);
            $result = $db->execute();
            
            //redirects user back to building form
            $msg = JText::_( 'COM_PARKWAY_POST_DELETEFACTSHEET' );
            $this->setRedirect( 'index.php?option=com_parkway&view=building&layout=edit&id='.$id );
        }
        public function deleteImage(){
            $form   = JRequest::getVar( 'jform','','post', 'array', JREQUEST_ALLOWHTML );
            $id     = $form['id'];
            
            //find factsheet
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__parkway_buildings');  
            $query->where('id = '.$id);
            
            $db->setQuery($query);
            $result = $db->loadObject();    
            
                      
            //delete file
            JFile::delete(JPATH_ROOT.'/media/com_parkway/'.$result->image);
            
            //delete image in database
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->update('#__parkway_buildings');
            $query->set('image = "" ');  
            $query->where('id = '.$id);
            
            $db->setQuery($query);
            $result = $db->execute();
            
            //redirects user back to building form
            $msg = JText::_( 'COM_PARKWAY_POST_DELETEIMAGE' );
            $this->setRedirect( 'index.php?option=com_parkway&view=building&layout=edit&id='.$id );
        }
        public function deleteImageThumb(){
            $form   = JRequest::getVar( 'jform','','post', 'array', JREQUEST_ALLOWHTML );
            $id     = $form['id'];
            
            //find factsheet
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__parkway_buildings');  
            $query->where('id = '.$id);
            
            $db->setQuery($query);
            $result = $db->loadObject();    
            
                      
            //delete file
            JFile::delete(JPATH_ROOT.'/media/com_parkway/'.$result->imagethumb);
            
            //delete image in database
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->update('#__parkway_buildings');
            $query->set('imagethumb = "" ');  
            $query->where('id = '.$id);
            
            $db->setQuery($query);
            $result = $db->execute();
            
            //redirects user back to building form
            $msg = JText::_( 'COM_PARKWAY_POST_DELETEIMAGE' );
            $this->setRedirect( 'index.php?option=com_parkway&view=building&layout=edit&id='.$id );
        }

	
}

