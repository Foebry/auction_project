import React, { useEffect, useMemo, useState } from "react";
import { MdDelete, MdModeEdit } from "react-icons/md";
import { useGetUsersQuery, useDeleteUserMutation } from "../../data/userAPI";
import ConfirmationModal from "../../components/modals/messageModals/ConfirmationModal";
import Pagination from "../../components/Pagination";

const Users = () => {
    const [nameFilter, setNameFilter] = useState("");
    const [confirm, setConfirm] = useState(false);
    const [userToDelete, setUserToDelete] = useState();
    const [deleteUser] = useDeleteUserMutation();
    const [page, setPage] = useState(1);
    const [options, setOptions] = useState({ page, page_count: 20 });

    const { data, isError, isLoading } = useGetUsersQuery(options, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    useEffect(() => {
        setOptions({ ...options, page });
    }, [page]);

    const confirmationHandler = (e) => {
        setUserToDelete(e.target.dataset.id);
        setConfirm(true);
    };

    const handleDelete = async () => {
        const { error } = await deleteUser(userToDelete);

        if (error) {
            console.log(error);
        } else {
            setConfirm(false);
            setUserToDelete(undefined);
        }
    };

    const memoData = useMemo(() => {
        return data?.users
            ?.filter((el) =>
                el.name.toLowerCase().includes(nameFilter.toLowerCase())
            )
            .map(({ id, name, email, isAdmin }) => {
                return (
                    <li className="list__user" key={id}>
                        <p>{name}</p>
                        <p className="list__user__email">{email}</p>
                        <p className="list__user__role">
                            {isAdmin ? "Admin" : "User"}
                        </p>
                        <div className="list__buttons">
                            <button className="list__buttons__button">
                                <MdModeEdit />
                            </button>
                            <button
                                className="list__buttons__button"
                                onClick={confirmationHandler}
                                data-id={id}
                            >
                                <MdDelete className="icon" />
                            </button>
                        </div>
                    </li>
                );
            });
    }, [data, nameFilter]);

    return (
        <section className="content" style={{ margin: "0 auto" }}>
            <ul className="list">
                <li className="list__user">
                    <p>Naam</p>
                    <p className="list__user__email">Email</p>
                    <p>Role</p>
                    <input
                        type="text"
                        placeholder="User Name"
                        value={nameFilter}
                        className="listFilter"
                        onChange={(e) => setNameFilter(e.target.value)}
                    />
                </li>
                {isError && <p>error..</p>}
                {isLoading && <p>loading..</p>}
                {memoData}
            </ul>
            <Pagination {...{ ...data, setPage }} />
            {confirm && (
                <ConfirmationModal
                    onPrimaryAction={handleDelete}
                    onSecondaryAction={() => setConfirm(false)}
                    onClose={() => setConfirm(false)}
                    message={`<p>You are about to delete '<span class="item">${
                        data?.users.filter((el) => el.id == userToDelete)[0]
                            ?.name
                    }</span>'.</p><br /><p>Are you sure?</p>`}
                ></ConfirmationModal>
            )}
        </section>
    );
};

export default Users;
