<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class RTM_RTMT_RTMDPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('RTMD');
            $this->SetMenuLabel('RTMD');
    
            $selectQuery = 'select cri.criteriaid, if(cri.testcaseid is null,\'Not cover\',cri.testcaseid) as `testcases` , if(ru.status is null, 0, ru.status) as `lastrun`, ru.createdate, ru.env , ru.runby from (SELECT c.id as criteriaid, c.code, ct.testcaseid FROM criterias c left join criteria_testcase ct on c.id=ct.criteriaid) cri left JOIN run ru on cri.testcaseid = ru.testcaseid';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'RTMD');
            $this->dataset->addFields(
                array(
                    new StringField('criteriaid', false, true),
                    new StringField('testcases', false, true),
                    new IntegerField('lastrun', false, true),
                    new DateTimeField('createdate', false, true),
                    new IntegerField('env', false, true),
                    new IntegerField('runby', false, true)
                )
            );
            $this->dataset->AddLookupField('criteriaid', 'criterias', new StringField('id'), new StringField('criteriadesc', false, false, false, false, 'criteriaid_criteriadesc', 'criteriaid_criteriadesc_criterias'), 'criteriaid_criteriadesc_criterias');
            $this->dataset->AddLookupField('testcases', 'testcases', new StringField('id'), new StringField('name', false, false, false, false, 'testcases_name', 'testcases_name_testcases'), 'testcases_name_testcases');
            $this->dataset->AddLookupField('lastrun', 'runstatus', new IntegerField('id'), new StringField('status', false, false, false, false, 'lastrun_status', 'lastrun_status_runstatus'), 'lastrun_status_runstatus');
            $this->dataset->AddLookupField('env', 'environments', new IntegerField('id'), new StringField('name', false, false, false, false, 'env_name', 'env_name_environments'), 'env_name_environments');
            $this->dataset->AddLookupField('runby', 'users', new IntegerField('id'), new StringField('user_name', false, false, false, false, 'runby_user_name', 'runby_user_name_users'), 'runby_user_name_users');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'criteriaid', 'criteriaid_criteriadesc', 'Criteriaid'),
                new FilterColumn($this->dataset, 'testcases', 'testcases_name', 'Testcases'),
                new FilterColumn($this->dataset, 'lastrun', 'lastrun_status', 'Lastrun'),
                new FilterColumn($this->dataset, 'createdate', 'createdate', 'Createdate'),
                new FilterColumn($this->dataset, 'env', 'env_name', 'Env'),
                new FilterColumn($this->dataset, 'runby', 'runby_user_name', 'Runby')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['criteriaid'])
                ->addColumn($columns['testcases'])
                ->addColumn($columns['lastrun'])
                ->addColumn($columns['createdate'])
                ->addColumn($columns['env'])
                ->addColumn($columns['runby']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('testcases')
                ->setOptionsFor('lastrun')
                ->setOptionsFor('createdate')
                ->setOptionsFor('env')
                ->setOptionsFor('runby');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_criteriaid_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('criteriaid', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_criteriaid_search');
            
            $text_editor = new TextEdit('criteriaid');
            
            $filterBuilder->addColumn(
                $columns['criteriaid'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('testcases_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_testcases_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('testcases', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_testcases_search');
            
            $text_editor = new TextEdit('testcases');
            
            $filterBuilder->addColumn(
                $columns['testcases'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('lastrun_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_lastrun_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('lastrun', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_lastrun_search');
            
            $filterBuilder->addColumn(
                $columns['lastrun'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('createdate_edit', false, 'Y-m-d H:i:s');
            
            $filterBuilder->addColumn(
                $columns['createdate'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('env_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_env_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('env', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_env_search');
            
            $filterBuilder->addColumn(
                $columns['env'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('runby_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_runby_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('runby', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_RTMD_runby_search');
            
            $filterBuilder->addColumn(
                $columns['runby'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('testcases', 'testcases_name', 'Testcases', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('lastrun', 'lastrun_status', 'Lastrun', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for createdate field
            //
            $column = new DateTimeViewColumn('createdate', 'createdate', 'Createdate', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('env', 'env_name', 'Env', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('runby', 'runby_user_name', 'Runby', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('testcases', 'testcases_name', 'Testcases', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('lastrun', 'lastrun_status', 'Lastrun', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for createdate field
            //
            $column = new DateTimeViewColumn('createdate', 'createdate', 'Createdate', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('env', 'env_name', 'Env', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('runby', 'runby_user_name', 'Runby', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for criteriaid field
            //
            $editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Criteriaid', 'criteriaid', 'criteriaid_criteriadesc', 'edit_RTM_RTMT_RTMD_criteriaid_search', $editor, $this->dataset, $lookupDataset, 'id', 'criteriadesc', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for testcases field
            //
            $editor = new DynamicCombobox('testcases_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`testcases`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('tfsid', true),
                    new StringField('name', true),
                    new StringField('teamid', true),
                    new IntegerField('status', true),
                    new IntegerField('testcases_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastupdate'),
                    new BooleanField('ui', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Testcases', 'testcases', 'testcases_name', 'edit_RTM_RTMT_RTMD_testcases_search', $editor, $this->dataset, $lookupDataset, 'id', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for lastrun field
            //
            $editor = new DynamicCombobox('lastrun_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Lastrun', 'lastrun', 'lastrun_status', 'edit_RTM_RTMT_RTMD_lastrun_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for createdate field
            //
            $editor = new DateTimeEdit('createdate_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Createdate', 'createdate', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for env field
            //
            $editor = new DynamicCombobox('env_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`environments`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('name', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Env', 'env', 'env_name', 'edit_RTM_RTMT_RTMD_env_search', $editor, $this->dataset, $lookupDataset, 'id', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for runby field
            //
            $editor = new DynamicCombobox('runby_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Runby', 'runby', 'runby_user_name', 'edit_RTM_RTMT_RTMD_runby_search', $editor, $this->dataset, $lookupDataset, 'id', 'user_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for criteriaid field
            //
            $editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Criteriaid', 'criteriaid', 'criteriaid_criteriadesc', 'multi_edit_RTM_RTMT_RTMD_criteriaid_search', $editor, $this->dataset, $lookupDataset, 'id', 'criteriadesc', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for testcases field
            //
            $editor = new DynamicCombobox('testcases_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`testcases`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('tfsid', true),
                    new StringField('name', true),
                    new StringField('teamid', true),
                    new IntegerField('status', true),
                    new IntegerField('testcases_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastupdate'),
                    new BooleanField('ui', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Testcases', 'testcases', 'testcases_name', 'multi_edit_RTM_RTMT_RTMD_testcases_search', $editor, $this->dataset, $lookupDataset, 'id', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for lastrun field
            //
            $editor = new DynamicCombobox('lastrun_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Lastrun', 'lastrun', 'lastrun_status', 'multi_edit_RTM_RTMT_RTMD_lastrun_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for createdate field
            //
            $editor = new DateTimeEdit('createdate_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Createdate', 'createdate', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for env field
            //
            $editor = new DynamicCombobox('env_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`environments`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('name', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Env', 'env', 'env_name', 'multi_edit_RTM_RTMT_RTMD_env_search', $editor, $this->dataset, $lookupDataset, 'id', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for runby field
            //
            $editor = new DynamicCombobox('runby_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Runby', 'runby', 'runby_user_name', 'multi_edit_RTM_RTMT_RTMD_runby_search', $editor, $this->dataset, $lookupDataset, 'id', 'user_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for criteriaid field
            //
            $editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Criteriaid', 'criteriaid', 'criteriaid_criteriadesc', 'insert_RTM_RTMT_RTMD_criteriaid_search', $editor, $this->dataset, $lookupDataset, 'id', 'criteriadesc', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for testcases field
            //
            $editor = new DynamicCombobox('testcases_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`testcases`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('tfsid', true),
                    new StringField('name', true),
                    new StringField('teamid', true),
                    new IntegerField('status', true),
                    new IntegerField('testcases_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastupdate'),
                    new BooleanField('ui', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Testcases', 'testcases', 'testcases_name', 'insert_RTM_RTMT_RTMD_testcases_search', $editor, $this->dataset, $lookupDataset, 'id', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for lastrun field
            //
            $editor = new DynamicCombobox('lastrun_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Lastrun', 'lastrun', 'lastrun_status', 'insert_RTM_RTMT_RTMD_lastrun_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for createdate field
            //
            $editor = new DateTimeEdit('createdate_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Createdate', 'createdate', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for env field
            //
            $editor = new DynamicCombobox('env_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`environments`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('name', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Env', 'env', 'env_name', 'insert_RTM_RTMT_RTMD_env_search', $editor, $this->dataset, $lookupDataset, 'id', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for runby field
            //
            $editor = new DynamicCombobox('runby_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Runby', 'runby', 'runby_user_name', 'insert_RTM_RTMT_RTMD_runby_search', $editor, $this->dataset, $lookupDataset, 'id', 'user_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('testcases', 'testcases_name', 'Testcases', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('lastrun', 'lastrun_status', 'Lastrun', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for createdate field
            //
            $column = new DateTimeViewColumn('createdate', 'createdate', 'Createdate', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('env', 'env_name', 'Env', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('runby', 'runby_user_name', 'Runby', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('testcases', 'testcases_name', 'Testcases', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('lastrun', 'lastrun_status', 'Lastrun', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for createdate field
            //
            $column = new DateTimeViewColumn('createdate', 'createdate', 'Createdate', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('env', 'env_name', 'Env', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('runby', 'runby_user_name', 'Runby', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('testcases', 'testcases_name', 'Testcases', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('lastrun', 'lastrun_status', 'Lastrun', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for createdate field
            //
            $column = new DateTimeViewColumn('createdate', 'createdate', 'Createdate', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('env', 'env_name', 'Env', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('runby', 'runby_user_name', 'Runby', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_RTMD_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`testcases`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('tfsid', true),
                    new StringField('name', true),
                    new StringField('teamid', true),
                    new IntegerField('status', true),
                    new IntegerField('testcases_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastupdate'),
                    new BooleanField('ui', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_RTMD_testcases_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_RTMD_lastrun_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`environments`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('name', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_RTMD_env_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_RTMD_runby_search', 'id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_RTMD_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`testcases`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('tfsid', true),
                    new StringField('name', true),
                    new StringField('teamid', true),
                    new IntegerField('status', true),
                    new IntegerField('testcases_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastupdate'),
                    new BooleanField('ui', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_RTMD_testcases_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_RTMD_lastrun_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`environments`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('name', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_RTMD_env_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_RTMD_runby_search', 'id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_RTMD_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`testcases`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('tfsid', true),
                    new StringField('name', true),
                    new StringField('teamid', true),
                    new IntegerField('status', true),
                    new IntegerField('testcases_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastupdate'),
                    new BooleanField('ui', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_RTMD_testcases_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_RTMD_lastrun_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`environments`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('name', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_RTMD_env_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_RTMD_runby_search', 'id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_RTMD_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`testcases`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('tfsid', true),
                    new StringField('name', true),
                    new StringField('teamid', true),
                    new IntegerField('status', true),
                    new IntegerField('testcases_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastupdate'),
                    new BooleanField('ui', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_RTMD_testcases_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_RTMD_lastrun_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`environments`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('name', true)
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_RTMD_env_search', 'id', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_RTMD_runby_search', 'id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class RTM_RTMTPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('RTMT');
            $this->SetMenuLabel('RTMT');
    
            $selectQuery = 'select teamid as rtm_teamid, cri2.appid, cri2.criteriaid, cri2.covered, cri2.tcstatus from (select cri.appid, cri.criteriaid, count(cri.testcaseid) as `covered`, case when max(ru.status) is null then 0 when max(ru.status) <=>3 then 3 when min(ru.status) <=>0 and max(ru.status) <=>1 then 2 when max(ru.status) <=>0 then 0 ELSE 1 end AS tcstatus from (SELECT c.appid, c.id as criteriaid, c.code, ct.testcaseid FROM criterias c left join criteria_testcase ct on c.id=ct.criteriaid) cri left JOIN (SELECT * FROM `run` r WHERE r.createdate in(select max(createdate) from run r2 WHERE r2.testcaseid = r.testcaseid)) ru on cri.testcaseid = ru.testcaseid group by cri.criteriaid) as cri2 INNER JOIN applications on cri2.appid = applications.id';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'RTMT');
            $this->dataset->addFields(
                array(
                    new StringField('rtm_teamid', false, true),
                    new StringField('appid', false, true),
                    new StringField('criteriaid', false, true),
                    new IntegerField('covered', false, true),
                    new IntegerField('tcstatus', false, true)
                )
            );
            $this->dataset->AddLookupField('appid', 'applications', new StringField('id'), new StringField('application', false, false, false, false, 'appid_application', 'appid_application_applications'), 'appid_application_applications');
            $this->dataset->AddLookupField('criteriaid', 'criterias', new StringField('id'), new StringField('criteriadesc', false, false, false, false, 'criteriaid_criteriadesc', 'criteriaid_criteriadesc_criterias'), 'criteriaid_criteriadesc_criterias');
            $this->dataset->AddLookupField('tcstatus', 'runstatus', new IntegerField('id'), new StringField('status', false, false, false, false, 'tcstatus_status', 'tcstatus_status_runstatus'), 'tcstatus_status_runstatus');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'rtm_teamid', 'rtm_teamid', 'Rtm Teamid'),
                new FilterColumn($this->dataset, 'appid', 'appid_application', 'Appid'),
                new FilterColumn($this->dataset, 'criteriaid', 'criteriaid_criteriadesc', 'Criteriaid'),
                new FilterColumn($this->dataset, 'covered', 'covered', 'Covered'),
                new FilterColumn($this->dataset, 'tcstatus', 'tcstatus_status', 'Tcstatus')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['rtm_teamid'])
                ->addColumn($columns['appid'])
                ->addColumn($columns['criteriaid'])
                ->addColumn($columns['covered'])
                ->addColumn($columns['tcstatus']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('criteriaid')
                ->setOptionsFor('tcstatus');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('rtm_teamid_edit');
            
            $filterBuilder->addColumn(
                $columns['rtm_teamid'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_appid_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('appid', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_appid_search');
            
            $text_editor = new TextEdit('appid');
            
            $filterBuilder->addColumn(
                $columns['appid'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_criteriaid_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('criteriaid', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_criteriaid_search');
            
            $text_editor = new TextEdit('criteriaid');
            
            $filterBuilder->addColumn(
                $columns['criteriaid'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('covered_edit');
            
            $filterBuilder->addColumn(
                $columns['covered'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('tcstatus_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_RTMT_tcstatus_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('tcstatus', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_RTMT_tcstatus_search');
            
            $filterBuilder->addColumn(
                $columns['tcstatus'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionsForPage('RTM.RTMT.RTMD')->HasViewGrant() && $withDetails)
            {
            //
            // View column for RTM_RTMT_RTMD detail
            //
            $column = new DetailColumn(array('criteriaid'), 'RTM.RTMT.RTMD', 'RTM_RTMT_RTMD_handler', $this->dataset, 'RTMD');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('tcstatus', 'tcstatus_status', 'Tcstatus', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for rtm_teamid field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('tcstatus', 'tcstatus_status', 'Tcstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for rtm_teamid field
            //
            $editor = new TextEdit('rtm_teamid_edit');
            $editColumn = new CustomEditColumn('Rtm Teamid', 'rtm_teamid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for appid field
            //
            $editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appid', 'appid', 'appid_application', 'edit_RTM_RTMT_appid_search', $editor, $this->dataset, $lookupDataset, 'id', 'application', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for criteriaid field
            //
            $editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Criteriaid', 'criteriaid', 'criteriaid_criteriadesc', 'edit_RTM_RTMT_criteriaid_search', $editor, $this->dataset, $lookupDataset, 'id', 'criteriadesc', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for covered field
            //
            $editor = new TextEdit('covered_edit');
            $editColumn = new CustomEditColumn('Covered', 'covered', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tcstatus field
            //
            $editor = new DynamicCombobox('tcstatus_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tcstatus', 'tcstatus', 'tcstatus_status', 'edit_RTM_RTMT_tcstatus_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for rtm_teamid field
            //
            $editor = new TextEdit('rtm_teamid_edit');
            $editColumn = new CustomEditColumn('Rtm Teamid', 'rtm_teamid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for appid field
            //
            $editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appid', 'appid', 'appid_application', 'multi_edit_RTM_RTMT_appid_search', $editor, $this->dataset, $lookupDataset, 'id', 'application', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for criteriaid field
            //
            $editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Criteriaid', 'criteriaid', 'criteriaid_criteriadesc', 'multi_edit_RTM_RTMT_criteriaid_search', $editor, $this->dataset, $lookupDataset, 'id', 'criteriadesc', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for covered field
            //
            $editor = new TextEdit('covered_edit');
            $editColumn = new CustomEditColumn('Covered', 'covered', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tcstatus field
            //
            $editor = new DynamicCombobox('tcstatus_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tcstatus', 'tcstatus', 'tcstatus_status', 'multi_edit_RTM_RTMT_tcstatus_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for rtm_teamid field
            //
            $editor = new TextEdit('rtm_teamid_edit');
            $editColumn = new CustomEditColumn('Rtm Teamid', 'rtm_teamid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for appid field
            //
            $editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appid', 'appid', 'appid_application', 'insert_RTM_RTMT_appid_search', $editor, $this->dataset, $lookupDataset, 'id', 'application', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for criteriaid field
            //
            $editor = new DynamicCombobox('criteriaid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Criteriaid', 'criteriaid', 'criteriaid_criteriadesc', 'insert_RTM_RTMT_criteriaid_search', $editor, $this->dataset, $lookupDataset, 'id', 'criteriadesc', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for covered field
            //
            $editor = new TextEdit('covered_edit');
            $editColumn = new CustomEditColumn('Covered', 'covered', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tcstatus field
            //
            $editor = new DynamicCombobox('tcstatus_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tcstatus', 'tcstatus', 'tcstatus_status', 'insert_RTM_RTMT_tcstatus_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for rtm_teamid field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('tcstatus', 'tcstatus_status', 'Tcstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for rtm_teamid field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('tcstatus', 'tcstatus_status', 'Tcstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for rtm_teamid field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for criteriadesc field
            //
            $column = new TextViewColumn('criteriaid', 'criteriaid_criteriadesc', 'Criteriaid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('tcstatus', 'tcstatus_status', 'Tcstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new RTM_RTMT_RTMDPage('RTM_RTMT_RTMD', $this, array('criteriaid'), array('criteriaid'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('RTM.RTMT.RTMD'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('RTM.RTMT.RTMD'));
            $detailPage->SetHttpHandlerName('RTM_RTMT_RTMD_handler');
            $handler = new PageHTTPHandler('RTM_RTMT_RTMD_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_RTMT_tcstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_RTMT_tcstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_RTMT_tcstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`criterias`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('code', true),
                    new StringField('criteriadesc', true),
                    new StringField('parent', true),
                    new IntegerField('criterias_userid', true),
                    new StringField('appid')
                )
            );
            $lookupDataset->setOrderByField('criteriadesc', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_criteriaid_search', 'id', 'criteriadesc', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_RTMT_tcstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class RTMPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('RTM');
            $this->SetMenuLabel('RTM');
    
            $selectQuery = 'select teamid as rtm_teamid, cri2.appid,concat(cast((sum(if(cri2.covered > 0, 1, 0))/count(cri2.criteriaid)) as DECIMAL)*100,\'%\') as covered,case when max(cri2.tcstatus) is null then 0 when max(cri2.tcstatus) <=>3 then 3 when min(cri2.tcstatus) <=>0 and max(cri2.tcstatus) <=>1 then 2 when max(cri2.tcstatus) <=>0 then 0 else 1 END AS appstatus from (select cri.appid, cri.criteriaid, count(cri.testcaseid) as `covered`, case when max(ru.status) is null then 0 when max(ru.status) <=>3 then 3 when min(ru.status) <=>0 and max(ru.status) <=>1 then 2 when max(ru.status) <=>0 then 0 ELSE 1 end AS tcstatus from (SELECT c.appid, c.id as criteriaid, c.code, ct.testcaseid FROM criterias c left join criteria_testcase ct on c.id=ct.criteriaid) cri left JOIN (SELECT * FROM `run` r WHERE r.createdate in(select max(createdate) from run r2 WHERE r2.testcaseid = r.testcaseid)) ru on cri.testcaseid = ru.testcaseid group by cri.criteriaid) as cri2 INNER JOIN applications on cri2.appid = applications.id group by cri2.appid order by cri2.tcstatus desc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'RTM');
            $this->dataset->addFields(
                array(
                    new StringField('rtm_teamid', false, true),
                    new StringField('appid', false, true),
                    new StringField('covered', false, true),
                    new IntegerField('appstatus', false, true)
                )
            );
            $this->dataset->AddLookupField('rtm_teamid', 'teams', new StringField('teamid'), new StringField('name', false, false, false, false, 'rtm_teamid_name', 'rtm_teamid_name_teams'), 'rtm_teamid_name_teams');
            $this->dataset->AddLookupField('appid', 'applications', new StringField('id'), new StringField('application', false, false, false, false, 'appid_application', 'appid_application_applications'), 'appid_application_applications');
            $this->dataset->AddLookupField('appstatus', 'runstatus', new IntegerField('id'), new StringField('status', false, false, false, false, 'appstatus_status', 'appstatus_status_runstatus'), 'appstatus_status_runstatus');
            $this->dataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'rtm_teamid in (SELECT `teamid` FROM `user_teams` WHERE `userid` = %CURRENT_USER_ID%)'));
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'rtm_teamid', 'rtm_teamid_name', 'Rtm Teamid'),
                new FilterColumn($this->dataset, 'appid', 'appid_application', 'Appid'),
                new FilterColumn($this->dataset, 'covered', 'covered', 'Covered'),
                new FilterColumn($this->dataset, 'appstatus', 'appstatus_status', 'Appstatus')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['rtm_teamid'])
                ->addColumn($columns['appid'])
                ->addColumn($columns['covered'])
                ->addColumn($columns['appstatus']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('appid')
                ->setOptionsFor('appstatus');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('rtm_teamid_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_rtm_teamid_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('rtm_teamid', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_rtm_teamid_search');
            
            $text_editor = new TextEdit('rtm_teamid');
            
            $filterBuilder->addColumn(
                $columns['rtm_teamid'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_appid_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('appid', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_appid_search');
            
            $text_editor = new TextEdit('appid');
            
            $filterBuilder->addColumn(
                $columns['appid'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('covered_edit');
            
            $filterBuilder->addColumn(
                $columns['covered'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('appstatus_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_RTM_appstatus_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('appstatus', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_RTM_appstatus_search');
            
            $filterBuilder->addColumn(
                $columns['appstatus'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionsForPage('RTM.RTMT')->HasViewGrant() && $withDetails)
            {
            //
            // View column for RTM_RTMT detail
            //
            $column = new DetailColumn(array('appid'), 'RTM.RTMT', 'RTM_RTMT_handler', $this->dataset, 'RTMT');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('appstatus', 'appstatus_status', 'Appstatus', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid_name', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('appstatus', 'appstatus_status', 'Appstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for rtm_teamid field
            //
            $editor = new DynamicCombobox('rtm_teamid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`teams`');
            $lookupDataset->addFields(
                array(
                    new StringField('teamid', true, true),
                    new StringField('name', true),
                    new IntegerField('teams_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange')
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Rtm Teamid', 'rtm_teamid', 'rtm_teamid_name', 'edit_RTM_rtm_teamid_search', $editor, $this->dataset, $lookupDataset, 'teamid', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for appid field
            //
            $editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appid', 'appid', 'appid_application', 'edit_RTM_appid_search', $editor, $this->dataset, $lookupDataset, 'id', 'application', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for covered field
            //
            $editor = new TextEdit('covered_edit');
            $editColumn = new CustomEditColumn('Covered', 'covered', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for appstatus field
            //
            $editor = new DynamicCombobox('appstatus_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appstatus', 'appstatus', 'appstatus_status', 'edit_RTM_appstatus_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for rtm_teamid field
            //
            $editor = new DynamicCombobox('rtm_teamid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`teams`');
            $lookupDataset->addFields(
                array(
                    new StringField('teamid', true, true),
                    new StringField('name', true),
                    new IntegerField('teams_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange')
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Rtm Teamid', 'rtm_teamid', 'rtm_teamid_name', 'multi_edit_RTM_rtm_teamid_search', $editor, $this->dataset, $lookupDataset, 'teamid', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for appid field
            //
            $editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appid', 'appid', 'appid_application', 'multi_edit_RTM_appid_search', $editor, $this->dataset, $lookupDataset, 'id', 'application', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for covered field
            //
            $editor = new TextEdit('covered_edit');
            $editColumn = new CustomEditColumn('Covered', 'covered', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for appstatus field
            //
            $editor = new DynamicCombobox('appstatus_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appstatus', 'appstatus', 'appstatus_status', 'multi_edit_RTM_appstatus_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for rtm_teamid field
            //
            $editor = new DynamicCombobox('rtm_teamid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`teams`');
            $lookupDataset->addFields(
                array(
                    new StringField('teamid', true, true),
                    new StringField('name', true),
                    new IntegerField('teams_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange')
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Rtm Teamid', 'rtm_teamid', 'rtm_teamid_name', 'insert_RTM_rtm_teamid_search', $editor, $this->dataset, $lookupDataset, 'teamid', 'name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for appid field
            //
            $editor = new DynamicCombobox('appid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appid', 'appid', 'appid_application', 'insert_RTM_appid_search', $editor, $this->dataset, $lookupDataset, 'id', 'application', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for covered field
            //
            $editor = new TextEdit('covered_edit');
            $editColumn = new CustomEditColumn('Covered', 'covered', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for appstatus field
            //
            $editor = new DynamicCombobox('appstatus_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Appstatus', 'appstatus', 'appstatus_status', 'insert_RTM_appstatus_search', $editor, $this->dataset, $lookupDataset, 'id', 'status', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid_name', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('appstatus', 'appstatus_status', 'Appstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid_name', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('appstatus', 'appstatus_status', 'Appstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for name field
            //
            $column = new TextViewColumn('rtm_teamid', 'rtm_teamid_name', 'Rtm Teamid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for application field
            //
            $column = new TextViewColumn('appid', 'appid_application', 'Appid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for covered field
            //
            $column = new TextViewColumn('covered', 'covered', 'Covered', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('appstatus', 'appstatus_status', 'Appstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new RTM_RTMTPage('RTM_RTMT', $this, array('appid'), array('appid'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('RTM.RTMT'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('RTM.RTMT'));
            $detailPage->SetHttpHandlerName('RTM_RTMT_handler');
            $handler = new PageHTTPHandler('RTM_RTMT_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`teams`');
            $lookupDataset->addFields(
                array(
                    new StringField('teamid', true, true),
                    new StringField('name', true),
                    new IntegerField('teams_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange')
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_rtm_teamid_search', 'teamid', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_RTM_appstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`teams`');
            $lookupDataset->addFields(
                array(
                    new StringField('teamid', true, true),
                    new StringField('name', true),
                    new IntegerField('teams_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange')
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_rtm_teamid_search', 'teamid', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_RTM_appstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`teams`');
            $lookupDataset->addFields(
                array(
                    new StringField('teamid', true, true),
                    new StringField('name', true),
                    new IntegerField('teams_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange')
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_rtm_teamid_search', 'teamid', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_RTM_appstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`teams`');
            $lookupDataset->addFields(
                array(
                    new StringField('teamid', true, true),
                    new StringField('name', true),
                    new IntegerField('teams_userid', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange')
                )
            );
            $lookupDataset->setOrderByField('name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_rtm_teamid_search', 'teamid', 'name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`applications`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('teamid'),
                    new StringField('application', true),
                    new DateTimeField('createdate'),
                    new DateTimeField('lastchange'),
                    new IntegerField('applications_userid', true)
                )
            );
            $lookupDataset->setOrderByField('application', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_appid_search', 'id', 'application', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`runstatus`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('status', true)
                )
            );
            $lookupDataset->setOrderByField('status', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_RTM_appstatus_search', 'id', 'status', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new RTMPage("RTM", "RTM.php", GetCurrentUserPermissionsForPage("RTM"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("RTM"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
