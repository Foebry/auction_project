const BaseModal = ({ children, onClose }) => {
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
