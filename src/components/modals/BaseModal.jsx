import React, { useContext } from "react";
import { AppContext } from "../../context/AppContext";

const BaseModal = ({ children, onCancel, onClose }) => {
    const { onBlur } = useContext(AppContext);

    return (
        <div className="modal">
            <div className="modal__closeBtn">
                <button onClick={onCancel || onClose || onBlur}>X</button>
            </div>
            {children}
        </div>
    );
};

export default BaseModal;
