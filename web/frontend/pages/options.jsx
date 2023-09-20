import {
  IndexTable,
  Card,
  useIndexResourceState,
  Page,
  Layout,
  TextContainer, Heading, EmptySearchResult, Modal, TextField, Loading, Frame
} from '@shopify/polaris';
import React from 'react';
import { useState } from "react";
import { TitleBar, Toast } from "@shopify/app-bridge-react";
import { useAppQuery, useAuthenticatedFetch } from "../hooks";

export default function Options() {
  const fetch = useAuthenticatedFetch();
  const [isLoading, setIsLoading] = useState(true);
  const [isAddDiscount, setIsAddDiscount] = useState(false);
  const [payPeriod, setPayPeriod] = useState('');
  const [discountCode, setDiscountCode] = useState('');
  const [discountPercentage, setDiscountPercentage] = useState('');
  const {
    data,
    refetch: refetchDiscountList,
    isLoading: isLoadingDiscount,
    isRefetching: isRefetchingDiscount,
  } = useAppQuery({
    url: "/api/option/list",
    reactQueryOptions: {
      onSuccess: () => {
        setIsLoading(false);
      },
    },
  });

  
  const resourceName = {
    singular: 'order',
    plural: 'orders',
  };

  const handleModalClose = () => {
    setIsAddDiscount(false);
  };
 
  const handlePayPeriodChange = (value) => {
    setPayPeriod(value);
  };

  const handleDiscountCodeChange = (value) => {
    setDiscountCode(value);
  };

  const handleDiscountPercentageChange = (value) => {
    setDiscountPercentage(value);
  };

  const handleFormSubmit = () => {
    // Do something with the text input
    handleSave();
    setIsAddDiscount(false);
  };

  const handleSave = async () => {
    const response = await fetch("/api/option/create",{
      method: "POST",
      body:{
        'payPeriod': payPeriod,
        'discountCode': discountCode,
        'discountPercentage': discountPercentage
      }
    });
    if (response.ok) {
      await refetchDiscountList();
      setToastProps({ content: "option created!" });
    } else {
      setIsLoading(false);
      setToastProps({
        content: "There was an error creating option. Please try again",
        error: true,
      });
    }
  };


  const {selectedResources, allResourcesSelected, handleSelectionChange} = useIndexResourceState(new Array());
  const emptyStateMarkup = (
    <EmptySearchResult
      title={'No option yet'}
      description={'Try changing the option or search term'}
      withIllustration
    />
  );
  const rowMarkup = !isLoading ? data.map(
    (
      {id, title, option_type_desc, instruction},
      index,
    ) => (
      <IndexTable.Row
        id={id}
        key={id}
        selected={selectedResources.includes(id)}
        position={index}
      >
        
        <IndexTable.Cell>{title}</IndexTable.Cell>
        <IndexTable.Cell>{option_type_desc}</IndexTable.Cell>
        <IndexTable.Cell>{instruction}</IndexTable.Cell>
      </IndexTable.Row>
    )
  )  : "";

  const table_content = !isLoading ? 
      <Layout>
        <Layout.Section>
          <Card>
            <IndexTable
              resourceName={resourceName}
              itemCount={data.length}
              // selectedItemsCount={
              //   allResourcesSelected ? 'All' : selectedResources.length
              // }
              // onSelectionChange={handleSelectionChange}
              emptyState={emptyStateMarkup}
              headings={[
                {title: 'Title'},
                {title: 'Otion Type'},
                {title: 'Instruction'},
              ]}
            >
              {rowMarkup}
            </IndexTable>
          </Card>
        </Layout.Section>
      </Layout>
      :
      <Frame>
        <Loading />
      </Frame> ;
 

  return (
    <Page>
      <TitleBar
        title="Option List"
        primaryAction={{
          content: "Add Option",
          onAction: () => {
            setIsAddDiscount(true);
          },
        }}
        // secondaryActions={[
        //   {
        //     content: "Secondary action",
        //     onAction: () => console.log("Secondary action"),
        //   },
        // ]}
      />
   
      {table_content}
   
      <Modal
        open={isAddDiscount}
        onClose={handleModalClose}
        title="Add Discount"
        primaryAction={{
          content: 'Add',
          onAction: handleFormSubmit,
        }}
        secondaryActions={[
          {
            content: 'Cancel',
            onAction: handleModalClose,
          },
        ]}
      >
        <Modal.Section>
          <TextField
            label="Pay Perid"
            value={payPeriod}
            onChange={handlePayPeriodChange}
          />

          <TextField
            label="Discount Code"
            value={discountCode}
            onChange={handleDiscountCodeChange}
          />

          <TextField
            label="Discount Percentage"
            value={discountPercentage}
            onChange={handleDiscountPercentageChange}
          />

        </Modal.Section>
      </Modal>
    </Page>
  );
}