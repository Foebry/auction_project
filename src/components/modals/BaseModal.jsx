import React, { useContext } from "react";
import { AppContext } from "../../context/AppContext";
import Detailmodal from "./Detailmodal";

const BaseModal = ({ children }) => {
    const { onClose } = useContext(AppContext);

    return (
        <div className="modal">
            <div className="modal__closeBtn">
                <button onClick={onClose}>X</button>
            </div>
            {children}
        </div>
    );
};

export default BaseModal;
