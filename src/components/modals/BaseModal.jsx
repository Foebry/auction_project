import React, { useContext } from "react";
import { AppContext } from "../../context/AppContext";

const BaseModal = ({ children, onCancel }) => {
    const { onClose } = useContext(AppContext);

    return (
        <div className="modal">
            <div className="modal__closeBtn">
                <button onClick={onCancel ?? onClose}>X</button>
            </div>
            {children}
        </div>
    );
};

export default BaseModal;
