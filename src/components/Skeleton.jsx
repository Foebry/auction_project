import React from "react";
import Header from "./Header";
import Navbar from "./Navbar";
import Footer from "./Footer";
import Categories from "./Categories";

const Skeleton = ({ children }) => {
  return (
    <>
      <Header />
      <Navbar />
      <Categories />
      {children}
      <Footer />
    </>
  );
};

export default Skeleton;
