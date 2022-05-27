import React, { useEffect, useMemo, useState } from "react";
import { MdDelete, MdModeEdit } from "react-icons/md";
import { useGetUsersQuery, useDeleteUserMutation } from "../data/userAPI";

const UserList = () => {
    const [nameFilter, setNameFilter] = useState("");

    const { data, isError, isLoading } = useGetUsersQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const memoData = useMemo(() => {
        return data
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
                                onClick={() => deleteUser(id)}
                            >
                                <MdDelete className="icon" />
                            </button>
                        </div>
                    </li>
                );
            });
    }, [data, nameFilter]);

    const [deleteUser] = useDeleteUserMutation();

    return (
        <>
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
        </>
    );
};

export default UserList;
