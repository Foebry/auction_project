import React from "react";
import Header from "./Header";
import Footer from "./Footer";

const Skeleton = ({ children }) => {
    return (
        <>
            <Header />
            {children}
            <Footer />
        </>
    );
};

export default Skeleton;
