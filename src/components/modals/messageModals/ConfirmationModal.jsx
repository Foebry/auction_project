import BaseModal from "../BaseModal";

const ConfirmationModal = ({
    message,
    onClose,
    onPrimaryAction,
    onSecondaryAction,
    type,
}) => {
    return (
        <BaseModal onClose={onClose}>
            <h1 style={{ fontSize: "20px", textAlign: "center" }}>
                Delete {type}
            </h1>
            <div
                style={{ textAlign: "center" }}
                dangerouslySetInnerHTML={{ __html: message }}
            ></div>
            <div style={{ display: "flex", justifyContent: "space-evenly" }}>
                <button
                    style={{
                        cursor: "pointer",
                        width: "20%",
                        height: "30px",
                        background: "#e63946",
                        borderRadius: "5px",
                        color: "#f1faee",
                        border: "none",
                    }}
                    onClick={onPrimaryAction}
                >
                    Delete
                </button>
                <button
                    style={{
                        cursor: "pointer",
                        width: "20%",
                        height: "30px",
                        background: "#31587a",
                        borderRadius: "5px",
                        color: "#f1faee",
                        border: "none",
                    }}
                    autoFocus={true}
                    onClick={onSecondaryAction}
                >
                    Cancel
                </button>
            </div>
            <div></div>
            <div></div>
            <div></div>
        </BaseModal>
    );
};

export default ConfirmationModal;
