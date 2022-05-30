import React, { useContext } from "react";
import { AppContext } from "../../context/AppContext";
import LoginModal from "./LoginModal";
import RegisterModal from "./RegisterModal";
import UserModal from "./UserModal";
import EditUserModal from "./EditUserModal";
import Detailblury__modal from "./DetailModal";
import UserProductsModal from "./UserProductsModal";
import AdminArticleModal from "./AdminArticleModal";
import AdminAuctionModal from "./AdminAuctionModal";

const Modal = () => {
    const { modal } = useContext(AppContext);

    if (typeof modal === "number") return <Detailblury__modal />;

    switch (modal) {
        case "login":
            return <LoginModal />;
        case "register":
            return <RegisterModal />;
        case "user":
            return <UserModal />;
        case "edit":
            return <EditUserModal />;
        case "userproducts":
            return <UserProductsModal />;
        case "adminArticle":
            return <AdminArticleModal />;
        case "adminAuction":
            return <AdminAuctionModal />;
    }
};

export default Modal;
