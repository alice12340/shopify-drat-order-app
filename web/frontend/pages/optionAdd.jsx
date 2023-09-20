import {
  IndexTable,
  Card,
  useIndexResourceState,
  Page,
  Layout,
  TextContainer, Heading, EmptySearchResult, TextField, Loading, Frame, Select
} from '@shopify/polaris';
import React, { useCallback } from 'react';
import { useState } from "react";
import { TitleBar, Toast } from "@shopify/app-bridge-react";
import { useAppQuery, useAuthenticatedFetch } from "../hooks";

export default function OptionAdd() {
  const fetch = useAuthenticatedFetch();
  const [isLoading, setIsLoading] = useState(true);
  const [isAddDiscount, setIsAddDiscount] = useState(false);
  const [payPeriod, setPayPeriod] = useState('');
  const [discountPercentage, setDiscountPercentage] = useState('');

  
 
  
  const handlePayPeriodChange = (value) => {
    setPayPeriod(value);
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


  const options = [
    {label: 'Switch Text', value: '1'},
    {label: 'Switch Color', value: '2'},
    {label: 'Switch Image', value: '3'},
  ];

  const [selected, setSelected] = useState('today');

  const handleSelectChange = (value) => {
    setSelected(value);
  };



  return (
    <Page>
      <TitleBar
        title="Option"
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
   
        <Layout>
          <Layout.Section>
            <TextField
              label="Title"
              value={payPeriod}
              onChange={handlePayPeriodChange}
            />
            
            <TextField
              label="Instruction"
              value={discountPercentage}
              onChange={handleDiscountPercentageChange}
              multiline={4}
            />

            <Select
              label="Option Type"
              options={options}
              onChange={handleSelectChange}
              value={selected}
            />

            <TextField
              label="option item"
              value={discountPercentage}
              onChange={handleDiscountPercentageChange}
              multiline={4}
            />

        </Layout.Section>
      </Layout>
    </Page>
  );
}