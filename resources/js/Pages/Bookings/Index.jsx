import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function Index({ bookings, filters }) {
    const { auth } = usePage().props;

    const [search, setSearch] = useState(filters.search ?? "");
    const [status, setStatus] = useState(filters.status ?? "");
    const [bookingDate, setBookingDate] = useState(filters.booking_date ?? "");

    const filterData = () => {
        router.get(
            "/bookings",
            {
                search,
                status,
                booking_date: bookingDate,
            },
            {
                preserveState: true,
                replace: true,
            },
        );
    };

    const resetFilter = () => {
        setSearch("");
        setStatus("");
        setBookingDate("");

        router.get("/bookings");
    };

    const deleteBooking = (id) => {
        if (!confirm("Yakin ingin menghapus data?")) {
            return;
        }

        router.delete(`/bookings/${id}`);
    };

    const approveBooking = (id) => {
        if (!confirm("Setujui pengajuan ini?")) {
            return;
        }

        router.patch(`/bookings/${id}/approve`);
    };

    const rejectBooking = (id) => {
        const reason = prompt("Alasan penolakan");

        if (reason == null) {
            return;
        }

        router.patch(`/bookings/${id}/reject`, {
            rejection_reason: reason,
        });
    };

    const badgeStatus = (status) => {
        switch (status) {
            case "Menunggu":
                return "warning";

            case "Disetujui":
                return "success";

            case "Ditolak":
                return "danger";

            case "Selesai":
                return "primary";

            default:
                return "secondary";
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="fs-4 fw-semibold">Data Pengajuan</h2>}
        >
            <Head title="Pengajuan Peminjaman" />

            <div className="container py-4">
                <div className="card shadow">
                    <div className="card-header bg-white">
                        <div className="d-flex justify-content-between align-items-center">
                            <h5 className="mb-0">Data Pengajuan Peminjaman</h5>

                            <Link
                                href="/bookings/create"
                                className="btn btn-primary"
                            >
                                + Tambah Pengajuan
                            </Link>
                        </div>
                    </div>

                    <div className="card-body">
                        {/* FILTER */}

                        <div className="row mb-4">
                            <div className="col-md-4">
                                <input
                                    type="text"
                                    className="form-control"
                                    placeholder="Cari Ruang / Dosen / Keperluan"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                />
                            </div>

                            <div className="col-md-3">
                                <select
                                    className="form-select"
                                    value={status}
                                    onChange={(e) => setStatus(e.target.value)}
                                >
                                    <option value="">Semua Status</option>

                                    <option value="Menunggu">Menunggu</option>

                                    <option value="Disetujui">Disetujui</option>

                                    <option value="Ditolak">Ditolak</option>

                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>

                            <div className="col-md-3">
                                <input
                                    type="date"
                                    className="form-control"
                                    value={bookingDate}
                                    onChange={(e) =>
                                        setBookingDate(e.target.value)
                                    }
                                />
                            </div>

                            <div className="col-md-2 d-grid gap-2">
                                <button
                                    className="btn btn-primary"
                                    onClick={filterData}
                                >
                                    Cari
                                </button>

                                <button
                                    className="btn btn-secondary"
                                    onClick={resetFilter}
                                >
                                    Reset
                                </button>
                            </div>
                        </div>

                        {/* TABLE */}

                        <div className="table-responsive">
                            <table className="table table-bordered table-hover align-middle">
                                <thead className="table-dark">
                                    <tr>
                                        <th width="50">No</th>

                                        <th>Dosen</th>

                                        <th>Ruangan</th>

                                        <th>Tanggal</th>

                                        <th>Jam</th>

                                        <th>Keperluan</th>

                                        <th>Status</th>

                                        <th width="250">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {bookings.data.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan="8"
                                                className="text-center"
                                            >
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    )}

                                    {bookings.data.map((booking, index) => (
                                        <tr key={booking.id}>
                                            <td>
                                                {(bookings.current_page - 1) *
                                                    bookings.per_page +
                                                    index +
                                                    1}
                                            </td>

                                            <td>{booking.user?.name}</td>

                                            <td>{booking.room?.room_name}</td>

                                            <td>{booking.booking_date}</td>

                                            <td>
                                                {booking.start_time}

                                                {" - "}

                                                {booking.end_time}
                                            </td>

                                            <td>{booking.purpose}</td>

                                            <td>
                                                <span
                                                    className={`badge bg-${badgeStatus(
                                                        booking.status,
                                                    )}`}
                                                >
                                                    {booking.status}
                                                </span>
                                            </td>

                                            <td>
                                                <div className="d-flex gap-1 flex-wrap">
                                                    <Link
                                                        href={`/bookings/${booking.id}/edit`}
                                                        className="btn btn-warning btn-sm"
                                                    >
                                                        Edit
                                                    </Link>

                                                    <button
                                                        className="btn btn-danger btn-sm"
                                                        onClick={() =>
                                                            deleteBooking(
                                                                booking.id,
                                                            )
                                                        }
                                                    >
                                                        Hapus
                                                    </button>

                                                    {booking.status ===
                                                        "Menunggu" && (
                                                        <>
                                                            <button
                                                                className="btn btn-success btn-sm"
                                                                onClick={() =>
                                                                    approveBooking(
                                                                        booking.id,
                                                                    )
                                                                }
                                                            >
                                                                Approve
                                                            </button>

                                                            <button
                                                                className="btn btn-secondary btn-sm"
                                                                onClick={() =>
                                                                    rejectBooking(
                                                                        booking.id,
                                                                    )
                                                                }
                                                            >
                                                                Reject
                                                            </button>
                                                        </>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {/* PAGINATION */}

                        <div className="mt-3">
                            <nav>
                                <ul className="pagination">
                                    {bookings.links.map((link, index) => (
                                        <li
                                            key={index}
                                            className={`page-item
                                                ${link.active ? "active" : ""}
                                                ${link.url == null ? "disabled" : ""}
                                            `}
                                        >
                                            <button
                                                className="page-link"
                                                dangerouslySetInnerHTML={{
                                                    __html: link.label,
                                                }}
                                                onClick={() => {
                                                    if (link.url) {
                                                        router.visit(link.url);
                                                    }
                                                }}
                                            />
                                        </li>
                                    ))}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
